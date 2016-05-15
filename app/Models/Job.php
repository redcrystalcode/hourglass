<?php

namespace Hourglass\Models;

use Hourglass\Models\Relations\BelongsToAccount;
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
 */
class Job extends Model
{
    use BelongsToAccount, SoftDeletes;

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
