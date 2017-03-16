<?php
declare(strict_types = 1);
namespace Hourglass\Entities\Behaviors;

use LaravelDoctrine\ORM\Serializers\Arrayable;

/**
 * Class SerializesToArray
 * @method array toArray()
 *
 * Default implementation for:
 * @see \Hourglass\Entities\Behaviors\Serializable
 */
trait SerializesToArray
{
    use Arrayable;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options = 0);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
