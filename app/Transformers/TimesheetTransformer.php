<?php
namespace Hourglass\Transformers;

use Hourglass\Models\Timesheet;

class TimesheetTransformer extends Transformer
{
    public function transform(Timesheet $timesheet) : array
    {
        $employee = $timesheet->employee;
        $group = $employee->agency;
        $job = $timesheet->job;
        $shift = $timesheet->shift;

        return [
            'id' => $timesheet->id,
            'employee' => [
                'name' => $employee->name,
                'position' => $employee->position,
                'terminal_key' => $employee->terminal_key,
                'group' => $group ? $group->name : null,
            ],
            'job' => [
                'name' => $job->name,
                'number' => $job->number,
            ],
            'shift' => [
                'id' => $shift->id,
                'created_at' => $shift->created_at,
            ],
            'time_in' => $timesheet->time_in->toDateTimeString(),
            'time_out' => $timesheet->time_out ? $timesheet->time_out->toDateTimeString() : null,
        ];
    }
}
