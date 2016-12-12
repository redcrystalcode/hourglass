<?php
declare(strict_types = 1);
namespace Hourglass\Database\Mappings;

use Hourglass\Entities\Account;
use Hourglass\Entities\Employee;
use Hourglass\Entities\Job;
use Hourglass\Entities\JobShift;
use Hourglass\Entities\TimesheetEntry;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class TimesheetEntryMapping extends EntityMapping
{
    /**
     * {@inheritDoc}
     */
    public function mapFor()
    {
        return TimesheetEntry::class;
    }

    /**
     * {@inheritDoc}
     */
    public function map(Fluent $builder)
    {
        $builder->increments('id');
        $builder->table('timesheets');
        $builder->belongsTo(Account::class, 'account');
        $builder->belongsTo(Employee::class, 'employee');
        $builder->belongsTo(Job::class, 'job');
        $builder->belongsTo(JobShift::class, 'shift')->setJoinColumn('job_shift_id');
        $builder->dateTime('start')->columnName('time_in');
        $builder->dateTime('end')->columnName('time_out')->nullable();
        $builder->timestamps();
    }

}
