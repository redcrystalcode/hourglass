<?php
declare(strict_types = 1);
namespace Hourglass\Database\Mappings;

use Hourglass\Entities\Account;
use Hourglass\Entities\User;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class AccountMapping extends EntityMapping
{
    /**
     * @return string
     */
    public function mapFor()
    {
        return Account::class;
    }

    /**
     * @param \LaravelDoctrine\Fluent\Fluent $builder
     */
    public function map(Fluent $builder)
    {
        $builder->increments('id');
        $builder->string('name');
        $builder->string('timezone');
        $builder->timestamps();
        $builder->hasMany(User::class, 'users')->mappedBy('account');
    }

}
