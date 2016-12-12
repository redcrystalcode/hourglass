<?php
declare(strict_types = 1);
namespace Hourglass\Database\Mappings;

use Hourglass\Entities\Account;
use Hourglass\Entities\Job;
use Hourglass\Entities\JobShift;
use Hourglass\Entities\Location;
use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;

class JobMapping extends EntityMapping
{
    /**
     * {@inheritdoc}
     */
    public function mapFor()
    {
        return Job::class;
    }

    /**
     * {@inheritdoc}
     */
    public function map(Fluent $builder)
    {
        $builder->increments('id');
        $builder->belongsTo(Account::class, 'account');
        $builder->string('name');
        $builder->string('number');
        $builder->string('description')->nullable();
        $builder->string('customer');
        $builder->belongsTo(Location::class, 'location');
        $builder->hasMany(JobShift::class, 'shifts')->mappedBy('job');
        $builder->jsonArray('productivity')->nullable();
        $builder->timestamps();
        $builder->softDelete();
        $builder->unique(['account_id', 'name', 'deleted_at']);
    }
}
