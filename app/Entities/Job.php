<?php
declare(strict_types = 1);
namespace Hourglass\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Hourglass\Entities\Behaviors\BelongsToAccount;
use Hourglass\Entities\Behaviors\ImmutableTimestamps;
use Hourglass\Entities\Behaviors\SoftDeletes;

class Job
{
    use ImmutableTimestamps, SoftDeletes, BelongsToAccount;

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $number;

    /** @var string */
    private $description;

    /** @var string */
    private $customer;

    /** @var \Hourglass\Entities\Location */
    private $location;

    /** @var array */
    private $productivity;

    /** @var \Doctrine\Common\Collections\Collection */
    private $shifts;

    /**
     * Job constructor.
     *
     * @param string $name
     * @param string $number
     * @param string $description
     * @param string $customer
     * @param \Hourglass\Entities\Location $location
     * @param array $productivity
     */
    public function __construct(
        string $name,
        string $number,
        string $description,
        string $customer,
        Location $location,
        array $productivity = []
    ) {
        $this->name = $name;
        $this->number = $number;
        $this->description = $description;
        $this->customer = $customer;
        $this->location = $location;
        $this->productivity = $productivity;
        $this->shifts = new ArrayCollection();
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
     * @return \Hourglass\Entities\Job
     */
    public function setName(string $name) : Job
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber() : string
    {
        return $this->number;
    }

    /**
     * @param string $number
     *
     * @return \Hourglass\Entities\Job
     */
    public function setNumber(string $number) : Job
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return \Hourglass\Entities\Job
     */
    public function setDescription(string $description) : Job
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomer() : string
    {
        return $this->customer;
    }

    /**
     * @param string $customer
     *
     * @return \Hourglass\Entities\Job
     */
    public function setCustomer(string $customer) : Job
    {
        $this->customer = $customer;
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
     * @return \Hourglass\Entities\Job
     */
    public function setLocation(Location $location) : Job
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return array
     */
    public function getProductivity() : array
    {
        return $this->productivity;
    }

    /**
     * @param array $productivity
     *
     * @return \Hourglass\Entities\Job
     */
    public function setProductivity(array $productivity) : Job
    {
        $this->productivity = $productivity;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShifts() : Collection
    {
        return $this->shifts;
    }
}
