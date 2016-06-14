<?php

namespace Hourglass\Http\Controllers\Api;

use Carbon\Carbon;
use Hourglass\Http\Requests;
use Hourglass\Http\Requests\Reports\CreateReportRequest;
use Hourglass\Models\Agency;
use Hourglass\Models\Employee;
use Hourglass\Models\Job;
use Hourglass\Models\JobShift;
use Hourglass\Models\Report;
use Hourglass\Models\Timesheet;
use Hourglass\Transformers\ReportTransformer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
     * @param  int $id
     *
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
     * @param  int $id
     *
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

        if ($type === 'agency') {
            return [
                'agency_id' => $request->get('agency_id'),
                'start' => $request->get('start'),
                'end' => $request->get('end'),
                'include_empty' => (bool)$request->get('include_empty', false),
                'include_archived' => (bool)$request->get('include_archived', false)
            ];
        }

        if ($type === 'shift') {
            return [
                'job_shift_id' => $request->get('job_shift_id')
            ];
        }

        if ($type === 'job') {
            return [
                'job_id' => $request->get('job_id')
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
                'type' => $report->type,
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

        if ($report->type === 'agency') {
            /** @var Agency $agency */
            $agency = $this->account->agencies()->with('employees.location')->findOrFail($parameters['agency_id']);
            $start = Carbon::parse($parameters['start'] . ' 00:00:00', 'America/Los_Angeles');
            $end = Carbon::parse($parameters['end'] . ' 23:59:59', 'America/Los_Angeles');

            $employees = [];
            foreach ($agency->employees as $employee) {
                if (!$parameters['include_archived'] && $employee->trashed()) {
                    continue;
                }
                $timesheets = $this->getEmployeeTimesheets($employee, $start, $end);
                if (!$parameters['include_empty'] && count($timesheets) === 0) {
                    continue;
                }
                $employees[] = [
                    'employee' => [
                        'name' => $employee->name,
                        'location' => $employee->location->name,
                        'agency' => $employee->agency->name ?? $this->account->name,
                    ],
                    'timesheets' => $timesheets,
                ];
            }

            return [
                'type' => $report->type,
                'include_archived' => $parameters['include_archived'],
                'include_empty' => $parameters['include_empty'],
                'agency' => [
                    'name' => $agency->name,
                ],
                'employees' => $employees,
                'start' => $start->tz('America/Los_Angeles')->toDateTimeString(),
                'end' => $end->tz('America/Los_Angeles')->toDateTimeString(),
            ];
        }

        if ($report->type === 'shift') {
            /** @var JobShift $shift */
            $shift = $this->account->shifts()->with('job.location')->findOrFail($parameters['job_shift_id']);
            $timesheets = Timesheet::with('employee')->where('job_shift_id', $shift->id)->get();
            return [
                'type' => $report->type,
                'job' => [
                    'name' => $shift->job->name,
                    'customer' => $shift->job->customer,
                    'number' => $shift->job->number,
                    'location' => $shift->job->location->name,
                    'productivity' => $shift->job->productivity
                ],
                'start' => $shift->created_at->toDateTimeString(),
                'end' => $shift->updated_at->toDateTimeString(),
                'shift' => [
                    'productivity' => $shift->productivity,
                    'score' => $this->calculateProductivityScoreForShift($shift, $timesheets),
                ],
                'timesheets' => $timesheets,
            ];
        }

        if ($report->type === 'job') {
            /** @var Job $job */
            $job = $this->account->jobs()->with('location')
                ->findOrFail($parameters['job_id']);
            /** @var JobShift[] $shifts */
            $shifts = $job->shifts()->orderBy('created_at', 'asc')
                ->where('closed', true)
                ->with('timesheets.employee')
                ->get();

            $shiftReports = [];
            foreach ($shifts as $shift) {
                // Clocked Out Only
                /** @var \Illuminate\Support\Collection|Timesheet[] $timesheets */
                $timesheets = $shift->timesheets()->whereNotNull('time_out')->with('employee')->get();
                $shiftReports[] = [
                    'start' => $timesheets->first()->time_in->toDateTimeString(),
                    'end' => $timesheets->last()->time_out->toDateTimeString(),
                    'shift' => [
                        'productivity' => $shift->productivity,
                    ],
                    'timesheets' => $timesheets,
                ];
            }
            return [
                'type' => $report->type,
                'job' => [
                    'name' => $job->name,
                    'customer' => $job->customer,
                    'number' => $job->number,
                    'location' => $job->location->name,
                    'productivity' => $job->productivity
                ],
                'start' => count($shifts) > 0 ? $shifts->first()->created_at->toDateTimeString() : null,
                'end' => count($shifts) > 0 ? $shifts->last()->updated_at->toDateTimeString() : null,
                'score' => $this->calculateProductivityScoreForJob($job, $shiftReports),
                'shifts' => $shiftReports,
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

    /**
     * @param \Hourglass\Models\JobShift $shift
     * @param \Illuminate\Support\Collection|\Hourglass\Models\Timesheet[] $timesheets
     *
     * @return int
     */
    private function calculateProductivityScoreForShift(JobShift $shift, Collection $timesheets)
    {
        $projectedQuantityPerHour = (int)$shift->job->productivity['quantity'];
        $numberOfPeopleRequired = (int)$shift->job->productivity['employees'];

        // Add up employee hours.
        $totalMinutes = 0;
        foreach ($timesheets as $timesheet) {
            $minutes = $timesheet->time_out->diffInMinutes($timesheet->time_in);
            $totalMinutes += $minutes;
        }

        $totalHours = $totalMinutes / 60;

        // Deduct Setup Time
        $totalHours -= (float)$shift->productivity['setup'];

        return $this->calculateProductivityScore(
            $projectedQuantityPerHour,
            $numberOfPeopleRequired,
            $totalHours,
            $shift->productivity['quantity']
        );
    }

    /**
     * Formula for Calculating Productivity Score:
     * GIVEN AT JOB ENTRY:
     *   numberOfEmployeesRequired
     *   projectedQuantityPerHour
     * GIVEN AT END OF JOB:
     *   actualQuantity
     *   setupTime
     * CALCULATED AT END OF JOB
     *   estimatedManHours = projectedQuantityPerHour/numberOfEmployeesRequired
     *   totalHours (+= every employee's time on the job) - setupTime
     *   actualManHours = actualQuantity/totalHours
     *   productivityScore = actualManHours/estManHours
     *
     * @param int $projectedQuantityPerHour
     * @param int $numberOfPeopleRequired
     * @param float $hoursWorked
     * @param int $totalQuantityProduced
     *
     * @return int
     */
    private function calculateProductivityScore(
        int $projectedQuantityPerHour,
        int $numberOfPeopleRequired,
        float $hoursWorked,
        int $totalQuantityProduced
    ) {
        if ($numberOfPeopleRequired === 0 || $hoursWorked <= 0) {
            return 0; // Prevent divide by zero.
        }

        $estimatedManHours = $projectedQuantityPerHour / $numberOfPeopleRequired;

        if ($estimatedManHours <= 0) {
            return 0; // Prevent divide by zero.
        }

        $actualManHours = $totalQuantityProduced / $hoursWorked;

        return (int)round(($actualManHours / $estimatedManHours) * 100);
    }

    private function calculateProductivityScoreForJob(Job $job, array $shiftReports)
    {
        $projectedQuantityPerHour = $job->productivity['quantity'];
        $numberOfPeopleRequired = $job->productivity['employees'];

        $minutesWorked = 0;
        $totalQuantityProduced = 0;

        foreach ($shiftReports as $report) {
            $shift = $report['shift'];
            foreach ($report['timesheets'] as $timesheet) {
                $minutes = $timesheet->time_out->diffInMinutes($timesheet->time_in);
                $minutesWorked += $minutes;
            }

            // Deduct setup time (in hours)
            $minutesWorked -= ($shift['productivity']['setup'] * 60);

            // Tally up quantity
            $totalQuantityProduced += $shift['productivity']['quantity'];
        }

        $hoursWorked = $minutesWorked / 60;

        return $this->calculateProductivityScore(
            $projectedQuantityPerHour,
            $numberOfPeopleRequired,
            $hoursWorked,
            $totalQuantityProduced
        );
    }
}
