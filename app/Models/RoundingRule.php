<?php

namespace Hourglass\Models;

use Hourglass\Models\Relations\BelongsToAccount;
use Illuminate\Database\Eloquent\Model;

/**
 * Hourglass\Models\RoundingRule
 *
 * @property integer $id
 * @property integer $account_id
 * @property string $start
 * @property string $end
 * @property mixed $criteria
 * @property string $resolution
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Hourglass\Models\Account $account
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\RoundingRule whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\RoundingRule whereAccountId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\RoundingRule whereStart($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\RoundingRule whereEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\RoundingRule whereCriteria($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\RoundingRule whereResolution($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\RoundingRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\RoundingRule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RoundingRule extends Model
{
    use BelongsToAccount;
    
    protected $casts = [
        'criteria' => 'array'
    ];
    
    protected $fillable = [
        'start',
        'end',
        'criteria',
        'resolution'
    ];
}
