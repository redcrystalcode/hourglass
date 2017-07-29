<?php
declare(strict_types = 1);

namespace Hourglass\Http\Controllers\Api;

use Hourglass\Transformers\JobShiftTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShiftController extends BaseController
{
	/**
	 * ShiftController constructor.
	 *
	 * @param \Hourglass\Transformers\JobShiftTransformer $transformer
	 */
    public function __construct(JobShiftTransformer $transformer)
    {
        parent::__construct();
        $this->transformer = $transformer;
	}

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $search = $request->get('search');
        $paginate = $this->resolveAccount($this->account)->shifts()->join('jobs', 'job_shifts.job_id', '=', 'jobs.id')
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
