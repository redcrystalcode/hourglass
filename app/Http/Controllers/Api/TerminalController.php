<?php

namespace Hourglass\Http\Controllers\Api;

use Carbon\Carbon;
use Hourglass\Http\Requests\Terminal\ClockRequest;
use Hourglass\Models\Employee;
use Hourglass\Models\Job;
use Hourglass\Models\JobShift;
use Hourglass\Models\Timesheet;
use Hourglass\Transformers\EmployeeTransformer;
use Hourglass\Transformers\TerminalTimesheetTransformer;

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
        $shift = JobShift::firstOrNew([
            'account_id' => $this->account->id,
            'job_id' => $job->id,
            'closed' => false
        ]);
        if ($shift->exists()) {
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
