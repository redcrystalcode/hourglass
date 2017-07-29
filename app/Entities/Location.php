<?php
declare(strict_types = 1);
namespace Hourglass\Entities;

use Hourglass\Entities\Behaviors\BelongsToAccount;
use Hourglass\Entities\Behaviors\ImmutableTimestamps;
use Hourglass\Entities\Behaviors\SoftDeletes;

class Location
{
    use ImmutableTimestamps, SoftDeletes, BelongsToAccount;

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /**
     * Location constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return \Hourglass\Entities\Location
     */
    public function setName(string $name) : Location
    {
        $this->name = $name;
        return $this;
    }
}
