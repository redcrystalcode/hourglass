<?php

namespace Hourglass\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Hourglass\Models\Account
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Account whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Account whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Account whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Hourglass\Models\Employee[] $employees
 * @property-read \Illuminate\Database\Eloquent\Collection|\Hourglass\Models\Job[] $jobs
 * @property-read \Illuminate\Database\Eloquent\Collection|\Hourglass\Models\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\Hourglass\Models\Location[] $locations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Hourglass\Models\Timesheet[] $timesheets
 * @property-read \Illuminate\Database\Eloquent\Collection|\Hourglass\Models\JobShift[] $shifts
 * @property-read \Illuminate\Database\Eloquent\Collection|\Hourglass\Models\Agency[] $agencies
 */
class Account extends Model
{
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function shifts()
    {
        return $this->hasMany(JobShift::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder
     */
    public function agencies()
    {
        return $this->hasMany(Agency::class);
    }
}
