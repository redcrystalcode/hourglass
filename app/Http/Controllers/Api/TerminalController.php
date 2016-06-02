<?php

namespace Hourglass\Http\Controllers\Api;

use Carbon\Carbon;
use Hourglass\Http\Requests\Terminal\ClockRequest;
use Hourglass\Http\Requests\Terminal\EndShiftRequest;
use Hourglass\Models\Employee;
use Hourglass\Models\Job;
use Hourglass\Models\JobShift;
use Hourglass\Models\PausedTimesheet;
use Hourglass\Models\Timesheet;
use Hourglass\Transformers\EmployeeTransformer;
use Hourglass\Transformers\JobShiftTransformer;
use Hourglass\Transformers\TerminalTimesheetTransformer;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TerminalController extends BaseController
{
    /** Status Constants */
    const STATUS_CLOCKED_IN = 'clocked_in';
    const STATUS_CLOCKED_OUT = 'clocked_out';
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

        $employee = $this->account->employees()->where('terminal_key', $terminalKey)->first();
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
            $job = $this->account->jobs()->find($jobId);
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
     * @return array
     */
    public function clockedInEmployees()
    {
        $timesheets = $this->account->timesheets()
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
        $timecards = $this->account->employees()->whereNotNull('terminal_key')->get(['id', 'terminal_key', 'name']);

        return [
            'data' => $timecards
        ];
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ongoingShifts()
    {
        /** @var JobShift[] $shifts */
        $shifts = $this->account->shifts()
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
    public function pauseShift($id)
    {
        /** @var JobShift $shift */
        $shift = $this->account->shifts()->with('timesheets')->find($id);

        if (!$shift) {
            throw new NotFoundHttpException('Not found.');
        }

        if ($shift->paused) {
            throw new BadRequestHttpException('This shift is already paused.');
        }

        $shift->paused = true;
        $clockOutTime = Carbon::now();
        foreach ($shift->timesheets as $timesheet) {
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
    public function resumeShift($id)
    {
        /** @var JobShift $shift */
        $shift = $this->account->shifts()->with('pausedTimesheets')->find($id);

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
    public function endShift(EndShiftRequest $request, $id)
    {
        /** @var JobShift $shift */
        $shift = $this->account->shifts()->find($id);

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

        return $this->respondWithItem($shift, new JobShiftTransformer());
    }

    /**
     * Determine if the employee is clocked in.
     *
     * @param \Hourglass\Models\Employee $employee
     *
     * @return bool
     */
    private function isEmployeeClockedIn(Employee $employee)
    {
        $timesheet = $this->getActiveTimesheetRecord($employee);

        return $timesheet !== null;
    }

    /**
     * @param \Hourglass\Models\Employee $employee
     *
     * @return null|\Hourglass\Models\Timesheet
     */
    private function getActiveTimesheetRecord(Employee $employee)
    {
        $timesheet = Timesheet::where('account_id', $this->account->id)
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
    private function clockIn(Employee $employee, Job $job)
    {
        /** @var JobShift $shift */
        $shift = $this->account->shifts()->where('job_id', $job->id)->where('closed', false)->first();
        if (!$shift) {
            $shift = new JobShift();
            $shift->job_id = $job->id;
            $shift->closed = false;
            $this->account->shifts()->save($shift);
        }

        $timesheet = new Timesheet();
        $timesheet->employee_id = $employee->id;
        $timesheet->job_id = $job->id;
        $timesheet->job_shift_id = $shift->id;
        $timesheet->time_in = Carbon::now();
        $this->account->timesheets()->save($timesheet);

        return $timesheet;
    }

    /**
     * @param \Hourglass\Models\Employee $employee
     *
     * @return \Hourglass\Models\Timesheet
     */
    private function clockOut(Employee $employee)
    {
        $timesheet = $this->getActiveTimesheetRecord($employee);

        $timesheet->time_out = Carbon::now();

        $timesheet->save();

        return $timesheet;
    }
}
