<?php

namespace Hourglass\Models;

use Hourglass\Models\Relations\BelongsToAccount;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Hourglass\Models\User
 *
 * @property integer $id
 * @property integer $account_id
 * @property string $name
 * @property string $role
 * @property string $email
 * @property string $password
 * @property string $timezone
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Hourglass\Models\Account $account
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\User whereAccountId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\User whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\User whereTimezone($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $username
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\User whereUsername($value)
 */
class User extends Authenticatable
{
    use BelongsToAccount;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'timezone', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var string[]
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
