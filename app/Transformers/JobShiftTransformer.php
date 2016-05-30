<?php
namespace Hourglass\Transformers;

use Hourglass\Models\JobShift;

class JobShiftTransformer extends Transformer
{
    public function transform(JobShift $shift) : array
    {
        return [
            'id' => $shift->id,
            'job' => [
                'id' => $shift->job->id,
                'name' => $shift->job->name,
                'number' => $shift->job->number,
            ],
            'productivity' => $shift->productivity,
            'closed' => (bool)$shift->closed,
            'created_at' => $shift->created_at->toDateTimeString(),
            'updated_at' => $shift->updated_at->toDateTimeString(),
        ];
    }
}
