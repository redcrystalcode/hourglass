<?php
declare(strict_types = 1);
namespace Hourglass\Entities;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Account
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $timezone;

    /** @var \Doctrine\Common\Collections\Collection */
    private $users;

    /** @var \DateTimeInterface */
    private $createdAt;

    /** @var \DateTimeInterface */
    private $updatedAt;

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

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt() : DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt() : DateTimeInterface
    {
        return $this->updatedAt;
    }
}
