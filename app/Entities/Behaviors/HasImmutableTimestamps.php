<?php
declare(strict_types = 1);
namespace Hourglass\Entities\Behaviors;

use DateTimeImmutable;

trait HasImmutableTimestamps
{
    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt() : DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable($this->createdAt);
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt() : DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable($this->updatedAt);
    }
}
