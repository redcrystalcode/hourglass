<?php
declare(strict_types = 1);
namespace Hourglass\Support;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

abstract class DateTimeUtils
{
    /**
     * Create a DateTimeImmutable instance from a DateTimeInterface instance.
     *
     * @param \DateTimeInterface $source
     *
     * @return \DateTimeImmutable
     */
    public static function toImmutable(DateTimeInterface $source) : DateTimeImmutable
    {
        return new DateTimeImmutable(
            $source->format('Y-m-d H:i:s.u'),
            new DateTimeZone($source->getTimeZone()->getName())
        );
    }

    /**
     * Create a DateTimeImmutable instance from a DateTimeInterface instance.
     *
     * @param \DateTimeInterface $source
     *
     * @return \DateTime
     */
    public static function toMutable(DateTimeInterface $source) : DateTime
    {
        return new DateTime(
            $source->format('Y-m-d H:i:s.u'),
            new DateTimeZone($source->getTimeZone()->getName())
        );
    }
}
