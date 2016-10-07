<?php
namespace Hourglass\Http\Controllers\Api;

use Hourglass\Http\Requests\Account\UpdateAccountRequest;
use Hourglass\Transformers\AccountTransformer;
use Illuminate\Contracts\Auth\Guard;
use League\Fractal\Manager as FractalManager;

/**
 * Class AccountController
 *
 * @package Hourglass\Http\Controllers\Api
 */
class AccountController extends BaseController
{
    /**
     * AccountController constructor.
     *
     * @param \Illuminate\Contracts\Auth\Guard $guard
     * @param \League\Fractal\Manager $fractal
     * @param \Hourglass\Transformers\AccountTransformer $transformer
     */
    public function __construct(Guard $guard, FractalManager $fractal, AccountTransformer $transformer)
    {
        parent::__construct($guard, $fractal);
        $this->transformer = $transformer;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        return $this->respondWithItem($this->account);
    }

    /**
     * @param \Hourglass\Http\Requests\Account\UpdateAccountRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAccountRequest $request)
    {
        $this->account->name = $request->get('name');
        $this->account->save();

        return $this->respondWithItem($this->account);
    }
}
