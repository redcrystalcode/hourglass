<?php
declare(strict_types = 1);

namespace Hourglass\Http\Controllers\Api;

use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Hourglass\Transformers\JobShiftTransformer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Manager as FractalManager;

class ShiftController extends BaseController
{
	/**
	 * ShiftController constructor.
	 *
	 * @param \Doctrine\ORM\EntityManagerInterface $em
	 * @param \Illuminate\Contracts\Auth\Guard $guard
	 * @param \League\Fractal\Manager $fractal
	 * @param \Hourglass\Transformers\JobShiftTransformer $transformer
	 */
    public function __construct(EntityManager $em, Guard $guard, FractalManager $fractal, JobShiftTransformer $transformer)
    {
        parent::__construct($em, $guard, $fractal);
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
