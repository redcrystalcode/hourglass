<?php
declare(strict_types = 1);
namespace Hourglass\Database\Mappings;

use Hourglass\Entities\Account;
use Hourglass\Entities\Report;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class ReportMapping extends EntityMapping
{
    /**
     * {@inheritDoc}
     */
    public function mapFor()
    {
        return Report::class;
    }

    /**
     * {@inheritDoc}
     */
    public function map(Fluent $builder)
    {
        $builder->string('id')->unique()->primary()->length(36);
        $builder->belongsTo(Account::class, 'account');
        $builder->string('name');
        $builder->string('note');
        $builder->string('type');
        $builder->jsonArray('parameters');
        $builder->timestamps();
    }
}
