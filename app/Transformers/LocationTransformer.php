<?php
namespace Hourglass\Transformers;

use Hourglass\Models\Location;

class LocationTransformer extends Transformer
{
    public function transform(Location $location) : array
    {
        return [
            'id' => $location->id,
            'name' => $location->name,
        ];
    }
}
