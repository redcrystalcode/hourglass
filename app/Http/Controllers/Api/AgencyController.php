<?php

namespace Hourglass\Http\Controllers\Api;

use Hourglass\Http\Requests;
//use Hourglass\Http\Requests\CreateAgencyRequest;
//use Hourglass\Http\Requests\Agencies\RegisterTimecardRequest;
//use Hourglass\Http\Requests\UpdateAgencyRequest;
use Hourglass\Models\Agency;
use Hourglass\Transformers\AgencyTransformer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use League\Fractal\Manager as FractalManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AgencyController extends BaseController
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
//    public function store(CreateAgencyRequest $request)
//    {
//        $employee = new Agency($request->only([
//            'name', 'position', 'terminal_key', 'location_id'
//        ]));
//        $this->account->employees()->save($employee);
//
//        return $this->respondWithItem($employee);
//    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
//    public function show($id)
//    {
//        /** @var Agency $employee */
//        $employee = $this->account->employees()->find($id);
//
//        if (!$employee) {
//            throw new NotFoundHttpException('Not found.');
//        }
//
//        return $this->respondWithItem($employee);
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Hourglass\Http\Requests\UpdateAgencyRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
//    public function update(UpdateAgencyRequest $request, $id)
//    {
//        /** @var Agency $employee */
//        $employee = $this->account->employees()->find($id);
//
//        if (!$employee) {
//            throw new NotFoundHttpException('Not found.');
//        }
//
//        $employee->fill($request->only(['name', 'position', 'terminal_key', 'location_id']));
//        $employee->save();
//
//        $this->respondWithItem($employee);
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // TODO - Implement destroy()
    }
}
