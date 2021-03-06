<?php
declare(strict_types = 1);
namespace Hourglass\Entities\Mappings;

use Hourglass\Entities\Account;
use Hourglass\Entities\User;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class AccountMapping extends EntityMapping
{
    /**
     * {@inheritdoc}
     */
    public function mapFor()
    {
        return Account::class;
    }

    /**
     * {@inheritdoc}
     */
    public function map(Fluent $builder)
    {
        $builder->increments('id');
        $builder->string('name');
        $builder->string('timezone')->default('America/Los_Angeles');
        $builder->timestamps();
        $builder->hasMany(User::class, 'users')->mappedBy('account');
    }
}
