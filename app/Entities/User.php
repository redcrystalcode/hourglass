<?php
declare(strict_types = 1);
namespace Hourglass\Entities;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Hourglass\Entities\Behaviors\BelongsToAccount;
use Hourglass\Entities\Behaviors\ImmutableTimestamps;
use Illuminate\Contracts\Auth\Authenticatable;

class User implements Authenticatable
{
    use ImmutableTimestamps, BelongsToAccount;

    /** @var int */
    private $id;

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
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return \Hourglass\Entities\User
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
     * @return \Hourglass\Entities\User
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
     * @return \Hourglass\Entities\User
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
     * @return \Hourglass\Entities\User
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
     * @return \Hourglass\Entities\User
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
     * @return \Hourglass\Entities\User
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
     * @return \Hourglass\Entities\User
     */
    public function setRememberToken($rememberToken)
    {
        assert_type($rememberToken, 'string');
        $this->rememberToken = $rememberToken;
        return $this;
    }

    /**
     * @return int
     */
    public function getAccountId() : int
    {
        return $this->account->getId();
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getId();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->getPassword();
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'rememberToken';
    }
}
