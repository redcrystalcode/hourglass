<?php
declare(strict_types = 1);

namespace Hourglass\Http\Controllers\Api;

use Hourglass\Http\Requests\Jobs\CreateJobRequest;
use Hourglass\Http\Requests\Jobs\UpdateJobRequest;
use Hourglass\Models\Job;
use Hourglass\Transformers\JobTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JobController extends BaseController
{
	/**
	 * JobController constructor.
	 *
	 * @param \Hourglass\Transformers\JobTransformer $transformer
	 */
    public function __construct(JobTransformer $transformer)
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
        $query = $this->resolveAccount($this->account)->jobs()
            ->with('location')
            ->search($request->get('search'))
            ->sortTrashedLast()
            ->sort($request->get('sort_by'), $request->get('order'));

        if ($request->get('include_deleted')) {
            $query->withTrashed();
        }

        return $this->respondWithPaginator($query->paginate($request->get('per_page', 10)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Hourglass\Http\Requests\Jobs\CreateJobRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateJobRequest $request) : JsonResponse
    {
        $job = new Job($request->only([
            'name', 'number', 'customer', 'description', 'productivity'
        ]));
        $job->location_id = $request->input('location.id');
        $this->resolveAccount($this->account)->jobs()->save($job);

        return $this->respondWithItem($job);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Hourglass\Http\Requests\Jobs\UpdateJobRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateJobRequest $request, int $id) : JsonResponse
    {
        /** @var Job $job */
        $job = $this->resolveAccount($this->account)->jobs()->find($id);
        $job->fill($request->only([
            'name', 'number', 'customer', 'description', 'productivity'
        ]));
        $job->location_id = $request->input('location.id');
        $this->resolveAccount($this->account)->jobs()->save($job);

        return $this->respondWithItem($job);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id) : JsonResponse
    {
        /** @var Job $job */
        $job = $this->resolveAccount($this->account)->jobs()->find($id);

        if (!$job) {
            throw new NotFoundHttpException('Not Found');
        }

        $job->delete();
        return $this->respondWithItem($job);
    }
}
