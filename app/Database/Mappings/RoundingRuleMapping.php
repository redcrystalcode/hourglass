<?php
declare(strict_types = 1);
namespace Hourglass\Database\Mappings;

use Hourglass\Entities\Account;
use Hourglass\Entities\RoundingRule;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class RoundingRuleMapping extends EntityMapping
{
    /**
     * {@inheritDoc}
     */
    public function mapFor()
    {
        return RoundingRule::class;
    }

    /**
     * {@inheritDoc}
     */
    public function map(Fluent $builder)
    {
        $builder->increments('id');
        $builder->belongsTo(Account::class, 'account');
        $builder->time('start');
        $builder->time('end');
        $builder->jsonArray('criteria');
        $builder->time('resolution');
        $builder->timestamps();
    }

}
