<?php
declare(strict_types = 1);
namespace Hourglass\Entities\Mappings;

use Hourglass\Entities\Account;
use Hourglass\Entities\JobShift;
use Hourglass\Entities\Job;
use Hourglass\Entities\Location;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class JobShiftMapping extends EntityMapping
{
    /**
     * {@inheritdoc}
     */
    public function mapFor()
    {
        return JobShift::class;
    }

    /**
     * {@inheritdoc}
     */
    public function map(Fluent $builder)
    {
        $builder->increments('id');
        $builder->belongsTo(Account::class, 'account');
        $builder->string('comment')->columnName('comments')->nullable();
        $builder->belongsTo(Job::class, 'job');
        $builder->jsonArray('productivity')->nullable();
        $builder->boolean('closed');
        $builder->boolean('paused');
        $builder->timestamps();
    }
}
