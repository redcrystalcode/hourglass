<?php
declare(strict_types = 1);
namespace Hourglass\Http\Controllers\Api;

use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Hourglass\Http\Requests\Account\UpdateAccountRequest;
use Hourglass\Transformers\AccountTransformer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
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
	 * @param \Doctrine\ORM\EntityManagerInterface $em
	 * @param \Illuminate\Contracts\Auth\Guard $guard
	 * @param \League\Fractal\Manager $fractal
	 * @param \Hourglass\Transformers\AccountTransformer $transformer
	 */
    public function __construct(EntityManager $em, Guard $guard, FractalManager $fractal, AccountTransformer $transformer)
    {
        parent::__construct($em, $guard, $fractal);
        $this->transformer = $transformer;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function show() : JsonResponse
    {
        return $this->respondWithItem($this->account);
    }

    /**
     * @param \Hourglass\Http\Requests\Account\UpdateAccountRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAccountRequest $request) : JsonResponse
    {
        $this->account->setName($request->get('name'));

        $this->em->persist($this->account);

        return $this->respondWithItem($this->account);
    }
}
