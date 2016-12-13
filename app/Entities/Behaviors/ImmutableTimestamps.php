<?php
declare(strict_types = 1);
namespace Hourglass\Entities\Behaviors;

use DateTimeImmutable;

trait ImmutableTimestamps
{
    /** @var \DateTime|null */
    private $createdAt;

    /** @var \DateTime|null */
    private $updatedAt;

    /**
     * @return \DateTimeImmutable|null
     */
    public function getCreatedAt() : ?DateTimeImmutable
    {
        if ($this->createdAt === null) {
            return null;
        }

        return DateTimeImmutable::createFromMutable($this->createdAt);
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getUpdatedAt() : ?DateTimeImmutable
    {
        if ($this->updatedAt === null) {
            return null;
        }
        return DateTimeImmutable::createFromMutable($this->updatedAt);
    }
}
