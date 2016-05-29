<?php

namespace Hourglass\Http\Controllers\Api;

use Hourglass\Http\Requests\Reports\CreateReportRequest;
use Hourglass\Models\Report;
use Hourglass\Transformers\ReportTransformer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Hourglass\Http\Requests;
use League\Fractal\Manager as FractalManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReportController extends BaseController
{
    /**
     * ReportController constructor.
     *
     * @param \Illuminate\Contracts\Auth\Guard $guard
     * @param \League\Fractal\Manager $fractal
     * @param \Hourglass\Transformers\ReportTransformer $transformer
     */
    public function __construct(Guard $guard, FractalManager $fractal, ReportTransformer $transformer)
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
        $reports = $this->account->reports()
            ->search($request->get('search'))
            ->sort($request->get('sort_by'), $request->get('order'))
            ->paginate($request->get('per_page', 10));

        return $this->respondWithPaginator($reports);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Hourglass\Http\Requests\Reports\CreateReportRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateReportRequest $request)
    {
        $report = new Report($request->only(['type']));
        $report->parameters = $this->getReportParameters($request);
        $report->generateName();
        $this->account->reports()->save($report);

        return $this->respondWithItem($report);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = $this->account->reports()->find($id);

        if (!$report) {
            throw new NotFoundHttpException('Not found.');
        }

        $report->delete();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    private function getReportParameters(Request $request)
    {
        $type = $request->get('type');

        if ($type === 'timesheet') {
            return [
                'employee_id' => $request->get('employee_id'),
                'start' => $request->get('start'),
                'end' => $request->get('end'),
            ];
        }
    }
}
