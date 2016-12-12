<?php
declare(strict_types = 1);
namespace Hourglass\Entities;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Hourglass\Entities\Behaviors\BelongsToAccount;
use Hourglass\Entities\Behaviors\ImmutableTimestamps;
use Hourglass\Support\DateTimeUtils;

class RoundingRule
{
    use ImmutableTimestamps, BelongsToAccount;

    /** @var int */
    private $id;

    /** @var \DateTime */
    private $start;

    /** @var \DateTime */
    private $end;

    /** @var array */
    private $criteria;

    /** @var \DateTime */
    private $resolution;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getStart() : DateTime
    {
        return $this->start;
    }

    /**
     * @param \DateTimeInterface $start
     *
     * @return \Hourglass\Entities\RoundingRule
     */
    public function setStart(DateTimeInterface $start) : RoundingRule
    {
        $this->start = DateTimeUtils::toMutable($start);
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getEnd() : DateTimeImmutable
    {
        return DateTimeUtils::toImmutable($this->end);
    }

    /**
     * @param \DateTime $end
     *
     * @return \Hourglass\Entities\RoundingRule
     */
    public function setEnd(DateTime $end) : RoundingRule
    {
        $this->end = DateTimeUtils::toMutable($end);
        return $this;
    }

    /**
     * @return array
     */
    public function getCriteria() : array
    {
        return $this->criteria;
    }

    /**
     * @param array $criteria
     *
     * @return \Hourglass\Entities\RoundingRule
     */
    public function setCriteria(array $criteria) : RoundingRule
    {
        $this->criteria = $criteria;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getResolution() : DateTimeImmutable
    {
        return DateTimeUtils::toImmutable($this->resolution);
    }

    /**
     * @param \DateTime $resolution
     *
     * @return \Hourglass\Entities\RoundingRule
     */
    public function setResolution(DateTime $resolution) : RoundingRule
    {
        $this->resolution = DateTimeUtils::toMutable($resolution);
        return $this;
    }


}
