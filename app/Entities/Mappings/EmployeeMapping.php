<?php
namespace Hourglass\Entities\Mappings;

use Hourglass\Entities\Account;
use Hourglass\Entities\Employee;
use Hourglass\Entities\EmployeeGroup;
use Hourglass\Entities\Location;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class EmployeeMapping extends EntityMapping
{
    /**
     * {@inheritdoc}
     */
    public function mapFor()
    {
        return Employee::class;
    }

    /**
     * {@inheritdoc}
     */
    public function map(Fluent $builder)
    {
        $builder->increments('id');
        $builder->belongsTo(Account::class, 'account');
        $builder->belongsTo(Location::class, 'location');
        $builder->belongsTo(EmployeeGroup::class, 'group')->setJoinColumn('agency_id');
        $builder->string('name');
        $builder->string('position')->nullable();
        $builder->string('key')->columnName('terminal_key')->nullable();
        $builder->timestamps();
        $builder->softDelete();
        $builder->unique(['account_id', 'terminal_key', 'deleted_at']);
        $builder->index('name');
    }
}
