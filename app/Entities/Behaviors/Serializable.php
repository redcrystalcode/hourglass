<?php
declare(strict_types = 1);
namespace Hourglass\Entities\Behaviors;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

interface Serializable extends Jsonable, Arrayable, JsonSerializable
{

}
