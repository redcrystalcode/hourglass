<?php
declare(strict_types = 1);
namespace Hourglass\Database\Mappings;

use Hourglass\Entities\Account;
use Hourglass\Entities\Employee;
use Hourglass\Entities\JobShift;
use Hourglass\Entities\PausedTimesheetEntry;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class PausedTimesheetEntryMapping extends EntityMapping
{
    /**
     * @inheritDoc
     */
    public function mapFor()
    {
        return PausedTimesheetEntry::class;
    }

    /**
     * @inheritDoc
     */
    public function map(Fluent $builder)
    {
        $builder->increments('id');
        $builder->table('paused_timesheets');
        $builder->belongsTo(Account::class, 'account');
        $builder->belongsTo(JobShift::class, 'shift')->setJoinColumn('job_shift_id');
        $builder->belongsTo(Employee::class, 'employee');
        $builder->timestamps();
    }

}
