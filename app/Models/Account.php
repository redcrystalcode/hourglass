<?php

namespace Hourglass\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Hourglass\Models\Account
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Account whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Account whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Account whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Account extends Model
{
    protected $fillable = ['name'];
}
