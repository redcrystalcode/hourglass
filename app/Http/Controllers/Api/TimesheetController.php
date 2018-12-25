<?php
declare(strict_types=1);

namespace Hourglass\Http\Controllers\Api;

use Hourglass\Http\Requests\Reports\CreateReportRequest;
use Hourglass\Models\Report;
use Hourglass\Transformers\TimesheetTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TimesheetController extends BaseController
{
    /**
     * ReportController constructor.
     *
     * @param \Hourglass\Transformers\TimesheetTransformer $transformer
     */
    public function __construct(TimesheetTransformer $transformer)
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
    public function index(Request $request): JsonResponse
    {
        $timesheets = $this->resolveAccount($this->account)->timesheets()
            ->sort($request->get('sort_by'), $request->get('order'))
            ->paginate($request->get('per_page', 10));

        return $this->respondWithPaginator($timesheets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Hourglass\Http\Requests\Reports\CreateReportRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateReportRequest $request): JsonResponse
    {
        $report = new Report($request->only(['type']));
        $report->parameters = $this->getReportParameters($request);
        $report->generateName();
        $this->resolveAccount($this->account)->reports()->save($report);

        return $this->respondWithItem($report);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return void
     */
    public function destroy(int $id): void
    {
        $report = $this->resolveAccount($this->account)->reports()->find($id);

        if (!$report) {
            throw new NotFoundHttpException('Not found.');
        }

        $report->delete();
    }
}
