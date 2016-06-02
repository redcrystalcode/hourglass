<?php

namespace Hourglass\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Hourglass\Models\PausedTimesheet
 *
 * @property integer $id
 * @property integer $account_id
 * @property integer $employee_id
 * @property integer $job_shift_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\PausedTimesheet whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\PausedTimesheet whereAccountId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\PausedTimesheet whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\PausedTimesheet whereJobShiftId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\PausedTimesheet whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\PausedTimesheet whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Hourglass\Models\JobShift $shift
 */
class PausedTimesheet extends Model
{
    protected $fillable = [
        'employee_id', 'job_shift_id', 'account_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Query\Builder
     */
    public function shift()
    {
        return $this->belongsTo(JobShift::class, 'job_shift_id');
    }
}
