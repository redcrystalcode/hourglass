<?php

namespace Hourglass\Http\Controllers\Api;

use Hourglass\Http\Requests\Groups\CreateGroupRequest;
use Hourglass\Http\Requests\Groups\UpdateGroupRequest;
use Hourglass\Models\Agency;
use Hourglass\Transformers\AgencyTransformer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use League\Fractal\Manager as FractalManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GroupController extends BaseController
{
    /**
     * AgencyController constructor.
     *
     * @param \Illuminate\Contracts\Auth\Guard $guard
     * @param \League\Fractal\Manager $fractal
     * @param \Hourglass\Transformers\AgencyTransformer $transformer
     */
    public function __construct(Guard $guard, FractalManager $fractal, AgencyTransformer $transformer)
    {
        parent::__construct($guard, $fractal);
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate = $this->account->agencies()
            ->search($request->get('search'))
            ->sort($request->get('sort_by'), $request->get('order'))
            ->paginate($request->get('per_page', 10));

        return $this->respondWithPaginator($paginate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Hourglass\Http\Requests\CreateAgencyRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGroupRequest $request)
    {
        $agencies = new Agency($request->only(['name']));
        $this->account->agencies()->save($agencies);

        return $this->respondWithItem($agencies);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /** @var Agency $agency */
        $agency = $this->account->agencies()->find($id);

        if (!$agency) {
            throw new NotFoundHttpException('Not found.');
        }

        return $this->respondWithItem($agency);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Hourglass\Http\Requests\UpdateAgencyRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupRequest $request, $id)
    {
        /** @var Agency $agency */
        $agency = $this->account->agencies()->find($id);

        if (!$agency) {
            throw new NotFoundHttpException('Not found.');
        }

        $agency->fill($request->only(['name']));
        $agency->save();

        $this->respondWithItem($agency);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // TODO - Allow deleting an agency.
        throw new \Exception('Cannot delete agency.');
        /** @var Agency $agency */
        $agency = $this->account->agencies()->find($id);

        if (!$agency) {
            throw new NotFoundHttpException('Not found.');
        }

        $agency->delete();
    }
}
