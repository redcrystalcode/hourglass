<?php
declare(strict_types = 1);
namespace Hourglass\Entities\Mappings;

use Hourglass\Entities\Employee;
use Hourglass\Entities\EmployeeGroup;
use Hourglass\Entities\Account;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class EmployeeGroupMapping extends EntityMapping
{
    /**
     * {@inheritdoc}
     */
    public function mapFor()
    {
        return EmployeeGroup::class;
    }

    /**
     * {@inheritdoc}
     */
    public function map(Fluent $builder)
    {
        $builder->increments('id');
        $builder->table('agencies');
        $builder->belongsTo(Account::class, 'account');
        $builder->hasMany(Employee::class, 'employees')->mappedBy('group');
        $builder->string('name');
        $builder->timestamps();
        $builder->unique(['account_id', 'name']);
    }
}
