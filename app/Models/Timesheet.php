<?php

namespace Hourglass\Models;

use Hourglass\Models\Relations\BelongsToAccount;
use Illuminate\Database\Eloquent\Model;

/**
 * Hourglass\Models\Timesheet
 *
 * @property integer $id
 * @property integer $employee_id
 * @property integer $job_id
 * @property integer $job_shift_id
 * @property \Carbon\Carbon $time_in
 * @property \Carbon\Carbon $time_out
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Hourglass\Models\Account $account
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Timesheet whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Timesheet whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Timesheet whereJobId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Timesheet whereJobShiftId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Timesheet whereTimeIn($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Timesheet whereTimeOut($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Timesheet whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Timesheet whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property integer $account_id
 * @property-read \Hourglass\Models\JobShift $shift
 * @property-read \Hourglass\Models\Job $job
 * @property-read \Hourglass\Models\Employee $employee
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Timesheet whereAccountId($value)
 */
class Timesheet extends Model
{
    use BelongsToAccount;

    /**
     * @var string[]
     */
    protected $dates = [
        'time_in', 'time_out', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo||\Illuminate\Database\Query\Builder
     */
    public function shift()
    {
        return $this->belongsTo(JobShift::class, 'job_shift_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo||\Illuminate\Database\Query\Builder
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo||\Illuminate\Database\Query\Builder
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
