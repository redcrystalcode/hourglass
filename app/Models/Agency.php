<?php

namespace Hourglass\Models;

use Hourglass\Models\Relations\BelongsToAccount;
use Illuminate\Database\Eloquent\Model;

/**
 * Hourglass\Models\Agency
 *
 * @property integer $id
 * @property integer $account_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Hourglass\Models\Account $account
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Agency whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Agency whereAccountId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Agency whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Agency whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Agency whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Agency extends Model
{
    use BelongsToAccount;
    
    protected $fillable = ['name'];
}
