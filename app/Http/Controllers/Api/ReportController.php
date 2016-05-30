<?php

namespace Hourglass\Http\Controllers\Api;

use Carbon\Carbon;
use DateTime;
use Hourglass\Http\Requests\Reports\CreateReportRequest;
use Hourglass\Models\Employee;
use Hourglass\Models\Report;
use Hourglass\Models\Timesheet;
use Hourglass\Transformers\EmployeeTransformer;
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
        /** @var Report $report */
        $report = $this->account->reports()->find($id);

        if (!$report) {
            throw new NotFoundHttpException('Not found.');
        }

        return [
            'data' => $this->generateReportData($report)
        ];
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

    private function generateReportData(Report $report)
    {
        $parameters = $report->parameters;
        if ($report->type === 'timesheet') {
            /** @var Employee $employee */
            $employee = $this->account->employees()
                ->with('agency')->with('location')
                ->findOrFail($parameters['employee_id']);
            $start = Carbon::parse($parameters['start'] . ' 00:00:00', 'America/Los_Angeles');
            $end = Carbon::parse($parameters['end'] . ' 23:59:59', 'America/Los_Angeles');
            $timesheets = $this->getEmployeeTimesheets($employee, $start, $end);
            return [
                'employee' => [
                    'name' => $employee->name,
                    'location' => $employee->location->name,
                    'agency' => $employee->agency->name ?? $this->account->name,
                ],
                'start' => $start->tz('America/Los_Angeles')->toDateTimeString(),
                'end' => $end->tz('America/Los_Angeles')->toDateTimeString(),
                'timesheets' => $timesheets,
            ];
        }
    }

    /**
     * @param \Hourglass\Models\Employee $employee
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     *
     * @return \Hourglass\Models\Timesheet[]
     */
    private function getEmployeeTimesheets(Employee $employee, Carbon $start, Carbon $end)
    {
        /** @var Timesheet[] $timesheets */
        $timesheets = Timesheet::with('job')
            ->where('time_in', '>=', $start)
            ->where('time_out', '<=', $end)
            ->where('employee_id', $employee->id)
            ->get();

        return $timesheets;
    }
}
