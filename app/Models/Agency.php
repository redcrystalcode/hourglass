<?php

namespace Hourglass\Models;

use Hourglass\Models\Relations\BelongsToAccount;
use Hourglass\Models\Scopes\IsSearchable;
use Hourglass\Models\Scopes\IsSortable;
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
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Agency sort($column, $direction)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Agency search($keyword)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Hourglass\Models\Employee[] $employees
 */
class Agency extends Model
{
    use BelongsToAccount, IsSortable, IsSearchable;

    protected $sortable = ['name', 'created_at'];

    protected $searchable = ['name'];

    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function employees()
    {
        return $this->hasMany(Employee::class)->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function activeEmployees()
    {
        return $this->hasMany(Employee::class);
    }
}
