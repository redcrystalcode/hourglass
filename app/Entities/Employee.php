<?php
declare(strict_types = 1);
namespace Hourglass\Entities;

use Hourglass\Entities\Behaviors\BelongsToAccount;
use Hourglass\Entities\Behaviors\ImmutableTimestamps;
use Hourglass\Entities\Behaviors\SoftDeletes;

class Employee
{
    use ImmutableTimestamps, SoftDeletes, BelongsToAccount;

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $position;

    /** @var string */
    private $key;

    /** @var \Hourglass\Entities\Location */
    private $location;

    /** @var \Hourglass\Entities\EmployeeGroup */
    private $group;

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
     * @return \Hourglass\Entities\Employee
     */
    public function setName(string $name) : Employee
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey() : string
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return \Hourglass\Entities\Employee
     */
    public function setKey(string $key) : Employee
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return \Hourglass\Entities\Location
     */
    public function getLocation() : Location
    {
        return $this->location;
    }

    /**
     * @param \Hourglass\Entities\Location $location
     *
     * @return \Hourglass\Entities\Employee
     */
    public function setLocation(Location $location) : Employee
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return \Hourglass\Entities\EmployeeGroup
     */
    public function getGroup() : EmployeeGroup
    {
        return $this->group;
    }

    /**
     * @param \Hourglass\Entities\EmployeeGroup $group
     *
     * @return \Hourglass\Entities\Employee
     */
    public function setGroup(EmployeeGroup $group) : Employee
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return string
     */
    public function getPosition() : string
    {
        return $this->position;
    }

    /**
     * @param string $position
     *
     * @return \Hourglass\Entities\Employee
     */
    public function setPosition(string $position) : Employee
    {
        $this->position = $position;
        return $this;
    }
}
