<?php
namespace Hourglass\Transformers;

use Hourglass\Models\Timesheet;

class TerminalTimesheetTransformer extends Transformer
{
    public function transform(Timesheet $timesheet) : array
    {
        return [
            'id' => $timesheet->id,
            'name' => $timesheet->employee->name,
            'job' => [
                'name' => $timesheet->job->name,
                'number' => $timesheet->job->number,
            ],
            'time_in' => $timesheet->time_in->toDateTimeString(),
            'time_out' => $timesheet->time_out ? $timesheet->time_out->toDateTimeString() : null,
        ];
    }
}
