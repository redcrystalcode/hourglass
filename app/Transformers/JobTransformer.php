<?php
namespace Hourglass\Transformers;

use Hourglass\Models\Job;

class JobTransformer extends Transformer
{
    public function transform(Job $job) : array
    {
        return [
            'id' => $job->id,
            'name' => $job->name,
            'number' => $job->number,
            'customer' => $job->customer,
            'description' => $job->description,
            'location' => [
                'id' => $job->location->id,
                'name' => $job->location->name,
            ],
            'productivity' => $job->productivity,
            'archived' => (bool)$job->trashed(),
        ];
    }
}
