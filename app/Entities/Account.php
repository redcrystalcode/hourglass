<?php
declare(strict_types = 1);
namespace Hourglass\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Hourglass\Entities\Behaviors\HasImmutableTimestamps;

class Account
{
    use HasImmutableTimestamps;

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $timezone;

    /** @var \Doctrine\Common\Collections\Collection */
    private $users;

    /**
     * Account constructor.
     *
     * @param string $name
     * @param string $timezone
     */
    public function __construct(string $name, string $timezone)
    {
        $this->name = $name;
        $this->timezone = $timezone;
        $this->users = new ArrayCollection();
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
     * @return Account
     */
    public function setName(string $name) : Account
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimezone() : string
    {
        return $this->timezone;
    }

    /**
     * @param string $timezone
     *
     * @return Account
     */
    public function setTimezone(string $timezone) : Account
    {
        $this->timezone = $timezone;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers() : Collection
    {
        return $this->users;
    }
}
