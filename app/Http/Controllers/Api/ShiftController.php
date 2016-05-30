<?php

namespace Hourglass\Http\Controllers\Api;

use Hourglass\Models\JobShift;
use Hourglass\Transformers\JobShiftTransformer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use League\Fractal\Manager as FractalManager;

class ShiftController extends BaseController
{
    /**
     * ShiftController constructor.
     *
     * @param \Illuminate\Contracts\Auth\Guard $guard
     * @param \League\Fractal\Manager $fractal
     * @param \Hourglass\Transformers\JobShiftTransformer $transformer
     */
    public function __construct(Guard $guard, FractalManager $fractal, JobShiftTransformer $transformer)
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
        $search = $request->get('search');
        $paginate = $this->account->shifts()->join('jobs', 'job_shifts.job_id', '=', 'jobs.id')
            ->where('job_shifts.closed', true)
            ->where(function($query) use ($search) {
                return $query->where('jobs.name', 'LIKE', "%$search%")
                    ->orWhere('jobs.number', 'LIKE', "%$search%");
            })
            ->orderBy('job_shifts.created_at', 'desc')
            ->select('job_shifts.*')
            ->paginate();

        return $this->respondWithPaginator($paginate);
    }
}
