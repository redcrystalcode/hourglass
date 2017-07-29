<?php
declare(strict_types = 1);
namespace Hourglass\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Hourglass\Entities\Behaviors\BelongsToAccount;
use Hourglass\Entities\Behaviors\ImmutableTimestamps;

class EmployeeGroup
{
    use ImmutableTimestamps, BelongsToAccount;

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var \Doctrine\Common\Collections\Collection */
    private $employees;

    /**
     * EmployeeGroup constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->employees = new ArrayCollection();
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
     * @return \Hourglass\Entities\EmployeeGroup
     */
    public function setName(string $name) : EmployeeGroup
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployees() : Collection
    {
        return $this->employees;
    }
}
