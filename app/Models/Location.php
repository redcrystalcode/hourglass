<?php

namespace Hourglass\Models;

use Hourglass\Models\Relations\BelongsToAccount;
use Hourglass\Models\Scopes\IsSearchable;
use Hourglass\Models\Scopes\IsSortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Hourglass\Models\Location
 *
 * @property integer $id
 * @property integer $account_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Hourglass\Models\Account $account
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Location whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Location whereAccountId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Location whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Location whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Location whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Location extends Model
{
    use BelongsToAccount, SoftDeletes, IsSearchable, IsSortable;

    protected $sortable = ['name', 'created_at'];

    protected $searchable = ['name'];

    protected $fillable = [
        'name'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
