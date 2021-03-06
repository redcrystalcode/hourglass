<?php
declare(strict_types = 1);

namespace Hourglass\Http\Controllers\Api;

use Carbon\Carbon;
use Hourglass\Http\Requests\Terminal\ClockRequest;
use Hourglass\Http\Requests\Terminal\EndShiftRequest;
use Hourglass\Models\Employee;
use Hourglass\Models\Job;
use Hourglass\Models\JobShift;
use Hourglass\Models\PausedTimesheet;
use Hourglass\Models\Report;
use Hourglass\Models\Timesheet;
use Hourglass\Transformers\EmployeeTransformer;
use Hourglass\Transformers\JobShiftTransformer;
use Hourglass\Transformers\TerminalTimesheetTransformer;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TerminalController extends BaseController
{
    /** Status Constants */
    const STATUS_CLOCKED_IN = 'clocked_in';
    const STATUS_CLOCKED_OUT = 'clocked_out';
    const STATUS_CONFIRM_CLOCK_OUT = 'confirm_clock_out';
    const STATUS_SELECT_JOB = 'select_job';

    /**
     * @param \Hourglass\Http\Requests\Terminal\ClockRequest $request
     *
     * @return mixed
     */
    public function clock(ClockRequest $request)
    {
        $transformer = new TerminalTimesheetTransformer();
        $terminalKey = $request->get('terminal_key');

        $employee = $this->resolveAccount($this->account)->employees()
			->where('terminal_key', $terminalKey)->first();

        /** @var PausedTimesheet $paused */
        $paused = PausedTimesheet::with('shift.job')->whereEmployeeId($employee->id)->first();

        if ($paused) {
            throw new HttpResponseException(new JsonResponse([
                'terminal_key' => "This employee is currently clocked in to the paused shift for "
                    . "Job #{$paused->shift->job->number}."
            ], 422));
        }

        // Check to see if the employee clocking out is clocking out too soon.
        if ($this->employeeClockedInRecently($employee) && !$request->has('clock_out_confirmed')) {
            return [
                'data' => [
                    'message' => "Clock in too recent. Confirm that the employee should be clocked out.",
                    'time_in' => $this->getActiveTimesheetRecord($employee)->time_in->toDateTimeString(),
                    'terminal_key' => $terminalKey,
                ],
                'status' => self::STATUS_CONFIRM_CLOCK_OUT,
            ];
        }

        if ($this->isEmployeeClockedIn($employee)) {
            $timesheet = $this->clockOut($employee);
            return [
                'data' => $transformer->transform($timesheet),
                'status' => self::STATUS_CLOCKED_OUT,
            ];
        }

        $jobId = $request->get('job_id');
        if ($jobId) {
            /** @var Job $job */
            $job = $this->resolveAccount($this->account)->jobs()->find($jobId);
            $timesheet = $this->clockIn($employee, $job);
            return [
                'data' => $transformer->transform($timesheet),
                'status' => self::STATUS_CLOCKED_IN,
            ];
        }

        return [
            'data' => (new EmployeeTransformer())->transform($employee),
            'status' => self::STATUS_SELECT_JOB,
        ];
    }

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function clockedInEmployees() : JsonResponse
    {
        $timesheets = $this->resolveAccount($this->account)->timesheets()
            ->whereNull('time_out')
            ->with('employee')
            ->with('job')
            ->get();

        return $this->respondWithCollection($timesheets, new TerminalTimesheetTransformer());
    }

    /**
     * Get all timecards assigned right now for UI purposes.
     * @return array
     */
    public function timecards()
    {
        $timecards = $this->resolveAccount($this->account)->employees()->whereNotNull('terminal_key')->get(['id', 'terminal_key', 'name']);

        return [
            'data' => $timecards
        ];
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ongoingShifts() : JsonResponse
    {
        /** @var JobShift[] $shifts */
        $shifts = $this->resolveAccount($this->account)->shifts()
            ->where('closed', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->respondWithCollection($shifts, new JobShiftTransformer());
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function pauseShift($id) : JsonResponse
    {
        /** @var JobShift $shift */
        $shift = $this->resolveAccount($this->account)->shifts()->with('timesheets')->find($id);

        if (!$shift) {
            throw new NotFoundHttpException('Not found.');
        }

        if ($shift->paused) {
            throw new BadRequestHttpException('This shift is already paused.');
        }

        $shift->paused = true;
        $clockOutTime = Carbon::now();
        foreach ($shift->timesheets()->whereNull('time_out')->get() as $timesheet) {
            $timesheet->time_out = $clockOutTime;
            $timesheet->save();

            $paused = new PausedTimesheet();
            $paused->account_id = $timesheet->account_id;
            $paused->employee_id = $timesheet->employee_id;
            $paused->job_shift_id = $timesheet->job_shift_id;
            $paused->save();
        }

        $shift->save();

        return $this->respondWithCollection($shift->timesheets, new TerminalTimesheetTransformer());
    }

    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resumeShift($id) : JsonResponse
    {
        /** @var JobShift $shift */
        $shift = $this->resolveAccount($this->account)->shifts()->with('pausedTimesheets')->find($id);

        if (!$shift) {
            throw new NotFoundHttpException('Not found.');
        }

        if (!$shift->paused) {
            throw new BadRequestHttpException('This shift is not yet paused.');
        }

        $shift->paused = false;
        $clockInTime = Carbon::now();
        $timesheets = new Collection();
        foreach ($shift->pausedTimesheets as $paused) {
            $timesheet = new Timesheet();
            $timesheet->account_id = $paused->account_id;
            $timesheet->employee_id = $paused->employee_id;
            $timesheet->job_shift_id = $paused->job_shift_id;
            $timesheet->job_id = $shift->job_id;
            $timesheet->time_in = $clockInTime;
            $timesheet->save();

            $paused->delete();

            $timesheets->push($timesheet);
        }

        $shift->save();

        return $this->respondWithCollection($timesheets, new TerminalTimesheetTransformer());
    }

    /**
     * @param \Hourglass\Http\Requests\Terminal\EndShiftRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function endShift(EndShiftRequest $request, int $id) : JsonResponse
    {
        /** @var JobShift $shift */
        $shift = $this->resolveAccount($this->account)->shifts()->find($id);

        if (!$shift) {
            throw new NotFoundHttpException('Not found.');
        }

        $shift->productivity = [
            'quantity' => $request->get('quantity'),
            'setup' => $request->get('setup')
        ];
        $shift->comments = $request->get('comments');
        $shift->closed = true;

        $shift->save();

        $this->createShiftReport($shift);

        return $this->respondWithItem($shift, new JobShiftTransformer());
    }

    /**
     * Determine if the employee is clocked in.
     *
     * @param \Hourglass\Models\Employee $employee
     *
     * @return bool
     */
    private function isEmployeeClockedIn(Employee $employee) : bool
    {
        $timesheet = $this->getActiveTimesheetRecord($employee);

        return $timesheet !== null;
    }

    /**
     * @param \Hourglass\Models\Employee $employee
     *
     * @return bool
     */
    private function employeeClockedInRecently(Employee $employee) : bool
    {
        $timesheet = $this->getActiveTimesheetRecord($employee);

        if ($timesheet === null) {
            return false;
        }

        $diff = $timesheet->time_in->diff(Carbon::now());

        return $diff->y === 0 && $diff->m === 0 && $diff->d === 0 && $diff->h === 0 && $diff->i < 5;
    }

    /**
     * @param \Hourglass\Models\Employee $employee
     *
     * @return null|\Hourglass\Models\Timesheet
     */
    private function getActiveTimesheetRecord(Employee $employee) : ?Timesheet
    {
        $timesheet = Timesheet::where('account_id', $this->resolveAccount($this->account)->id)
            ->where('employee_id', $employee->id)
            ->whereNull('time_out')
            ->first();
        return $timesheet;
    }

    /**
     * @param \Hourglass\Models\Employee $employee
     * @param \Hourglass\Models\Job $job
     *
     * @return \Hourglass\Models\Timesheet
     */
    private function clockIn(Employee $employee, Job $job) : Timesheet
    {
        /** @var JobShift $shift */
        $shift = $this->resolveAccount($this->account)->shifts()->where('job_id', $job->id)->where('closed', false)->first();
        if (!$shift) {
            $shift = new JobShift();
            $shift->job_id = $job->id;
            $shift->closed = false;
            $this->resolveAccount($this->account)->shifts()->save($shift);
        }

        $timesheet = new Timesheet();
        $timesheet->employee_id = $employee->id;
        $timesheet->job_id = $job->id;
        $timesheet->job_shift_id = $shift->id;
        $timesheet->time_in = Carbon::now();
        $this->resolveAccount($this->account)->timesheets()->save($timesheet);

        return $timesheet;
    }

    /**
     * @param \Hourglass\Models\Employee $employee
     *
     * @return \Hourglass\Models\Timesheet
     */
    private function clockOut(Employee $employee) : Timesheet
    {
        $timesheet = $this->getActiveTimesheetRecord($employee);

        $timesheet->time_out = Carbon::now();

        $timesheet->save();

        return $timesheet;
    }

    /**
     * TODO - DRY this up.
     * @param \Hourglass\Models\JobShift $shift
     */
    private function createShiftReport(JobShift $shift)
    {
        $report = new Report();
        $report->type = 'shift';
        $report->parameters = [
            'job_shift_id' => $shift->id,
        ];
        $report->generateName();
        $this->resolveAccount($this->account)->reports()->save($report);
    }
}
