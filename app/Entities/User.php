<?php
declare(strict_types = 1);
namespace Hourglass\Entities;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Hourglass\Entities\Behaviors\HasImmutableTimestamps;

class User
{
    use HasImmutableTimestamps;

    /** @var int */
    private $id;

    /** @var \Hourglass\Entities\Account */
    private $account;

    /** @var string */
    private $name;

    /** @var string */
    private $role;

    /** @var string */
    private $username;

    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /** @var string */
    private $timezone;

    /** @var string */
    private $rememberToken;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return \Hourglass\Entities\Account
     */
    public function getAccount() : Account
    {
        return $this->account;
    }

    /**
     * @param \Hourglass\Entities\Account $account
     *
     * @return User
     */
    public function setAccount(Account $account) : User
    {
        $this->account = $account;
        return $this;
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
     * @return User
     */
    public function setName(string $name) : User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole() : string
    {
        return $this->role;
    }

    /**
     * @param string $role
     *
     * @return User
     */
    public function setRole(string $role) : User
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername(string $username) : User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email) : User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password) : User
    {
        $this->password = bcrypt($password);
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
     * @return User
     */
    public function setTimezone(string $timezone) : User
    {
        $this->timezone = $timezone;
        return $this;
    }

    /**
     * @return string
     */
    public function getRememberToken() : string
    {
        return $this->rememberToken;
    }

    /**
     * @param string $rememberToken
     *
     * @return User
     */
    public function setRememberToken(string $rememberToken) : User
    {
        $this->rememberToken = $rememberToken;
        return $this;
    }
}
