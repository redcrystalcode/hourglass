<?php
declare(strict_types = 1);
namespace Hourglass\Entities\Mappings;

use Hourglass\Entities\Account;
use Hourglass\Entities\Location;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class LocationMapping extends EntityMapping
{
    /**
     * {@inheritdoc}
     */
    public function mapFor()
    {
        return Location::class;
    }

    /**
     * {@inheritdoc}
     */
    public function map(Fluent $builder)
    {
        $builder->increments('id');
        $builder->string('name')->unique();
        $builder->belongsTo(Account::class, 'account');
        $builder->timestamps();
        $builder->softDelete();
    }
}
