<?php
declare(strict_types = 1);
namespace Hourglass\Entities\Behaviors;

use DateTimeImmutable;

trait SoftDeletes
{
    /** @var \DateTime|null */
    private $deletedAt;

    /**
     * @return \DateTimeImmutable|null
     */
    public function getDeletedAt() : ?DateTimeImmutable
    {
        if ($this->deletedAt === null) {
            return null;
        }

        return DateTimeImmutable::createFromMutable($this->deletedAt);
    }

    public function isDeleted() : bool
    {
        return $this->deletedAt === null;
    }
}
