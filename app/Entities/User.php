<?php declare(strict_types = 1);
namespace Hourglass\Entities;

class User
{
    /** @var int */
    private $id;

    /** @var int */
    private $accountId;

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

    /** @var \DateTimeImmutable */
    private $createdAt;

    /** @var \DateTimeImmutable */
    private $updatedAt;
}
