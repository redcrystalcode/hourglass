<?php

namespace Hourglass\Models;

use Hourglass\Models\Relations\BelongsToAccount;
use Hourglass\Models\Scopes\IsSearchable;
use Hourglass\Models\Scopes\IsSortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Hourglass\Models\Employee
 *
 * @property integer $id
 * @property integer $account_id
 * @property string $name
 * @property string $position
 * @property string $terminal_key
 * @property integer $location_id
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Hourglass\Models\Account $account
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Employee whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Employee whereAccountId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Employee whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Employee wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Employee whereTerminalKey($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Employee whereLocationId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Employee whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Employee whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Employee search($keyword)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Employee sort($column, $direction)
 * @property integer $agency_id
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Employee whereAgencyId($value)
 */
class Employee extends Model
{
    use BelongsToAccount, SoftDeletes, IsSearchable, IsSortable;

    protected $searchable = ['name'];

    protected $sortable = ['name', 'created_at'];

    protected $fillable = [
        'name', 'position', 'terminal_key', 'location_id', 'agency_id'
    ];

    /**
     * @var string[]
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo||\Illuminate\Database\Query\Builder
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo||\Illuminate\Database\Query\Builder
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
