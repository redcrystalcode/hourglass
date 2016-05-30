<?php

namespace Hourglass\Models;

use Hourglass\Models\Relations\BelongsToAccount;
use Hourglass\Models\Scopes\IsSearchable;
use Hourglass\Models\Scopes\IsSortable;
use Illuminate\Database\Eloquent\Model;

/**
 * Hourglass\Models\JobShift
 *
 * @property integer $id
 * @property integer $account_id
 * @property integer $job_id
 * @property mixed $productivity
 * @property boolean $closed
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Hourglass\Models\Account $account
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\JobShift whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\JobShift whereAccountId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\JobShift whereJobId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\JobShift whereProductivity($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\JobShift whereClosed($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\JobShift whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\JobShift whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Hourglass\Models\Job $job
 * @property string $comments
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\JobShift whereComments($value)
 */
class JobShift extends Model
{
    use BelongsToAccount, IsSortable;

    /** @var array */
    protected $fillable = ['account_id', 'job_id', 'closed'];

    protected $sortable = ['created_at'];

    protected $casts = [
        'productivity' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Query\Builder
     */
    public function job()
    {
        return $this->belongsTo(Job::class)->withTrashed();
    }
}
