<?php
declare(strict_types = 1);
namespace Hourglass\Database\Mappings;

use Hourglass\Entities\Account;
use Hourglass\Entities\User;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class UserMapping extends EntityMapping
{
    /**
     * {@inheritdoc}
     */
    public function mapFor()
    {
        return User::class;
    }

    /**
     * {@inheritdoc}
     */
    public function map(Fluent $builder)
    {
        $builder->increments('id');
        $builder->string('name');
        $builder->string('role')->default('admin');
        $builder->string('username')->unique();
        $builder->string('email')->unique();
        $builder->string('password');
        $builder->string('timezone')->default('America/Los_Angeles');
        $builder->rememberToken()->columnName('remember_token');
        $builder->timestamps();
        $builder->belongsTo(Account::class, 'account');
    }
}
