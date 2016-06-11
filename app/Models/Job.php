<?php

namespace Hourglass\Models;

use Hourglass\Models\Relations\BelongsToAccount;
use Hourglass\Models\Scopes\IsSearchable;
use Hourglass\Models\Scopes\IsSortable;
use Hourglass\Models\Scopes\SortsTrashedLast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Hourglass\Models\Job
 *
 * @property integer $id
 * @property integer $account_id
 * @property string $name
 * @property string $number
 * @property string $description
 * @property string $customer
 * @property integer $location_id
 * @property mixed $productivity
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Hourglass\Models\Account $account
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Job whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Job whereAccountId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Job whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Job whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Job whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Job whereCustomer($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Job whereLocationId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Job whereProductivity($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Job whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Job whereDeletedAt($value)
 * @mixin \Eloquent
 * @property-read \Hourglass\Models\Location $location
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Job search($keyword)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Job sort($column, $direction)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Job sortTrashedLast()
 * @property-read \Illuminate\Database\Eloquent\Collection|\Hourglass\Models\JobShift[] $shifts
 */
class Job extends Model
{
    use BelongsToAccount, SoftDeletes, IsSearchable, IsSortable, SortsTrashedLast;

    protected $searchable = ['name', 'number'];

    protected $sortable = ['name', 'created_at'];

    protected $fillable = [
        'name', 'number', 'customer', 'description',
        'location_id', 'productivity'
    ];

    protected $casts = [
        'productivity' => 'array'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Query\Builder
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function shifts()
    {
        return $this->hasMany(JobShift::class);
    }
}
