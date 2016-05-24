<?php
namespace Hourglass\Transformers;

use Hourglass\Models\Agency;

class AgencyTransformer extends Transformer
{
    public function transform(Agency $agency) : array
    {
        return [
            'id' => $agency->id,
            'name' => $agency->name,
        ];
    }
}
