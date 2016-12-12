<?php
declare(strict_types = 1);
namespace Hourglass\Entities;

use DateTimeImmutable;
use DateTimeInterface;
use Hourglass\Entities\Behaviors\BelongsToAccount;
use Hourglass\Entities\Behaviors\ImmutableTimestamps;
use Hourglass\Support\DateTimeUtils;

class TimesheetEntry
{
    use BelongsToAccount, ImmutableTimestamps;

    /** @var int */
    private $id;

    /** @var \Hourglass\Entities\Employee */
    private $employee;

    /** @var \Hourglass\Entities\Job */
    private $job;

    /** @var \Hourglass\Entities\JobShift */
    private $shift;

    /** @var \DateTime */
    private $start;

    /** @var \DateTime|null */
    private $end;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return \Hourglass\Entities\Employee
     */
    public function getEmployee() : Employee
    {
        return $this->employee;
    }

    /**
     * @param \Hourglass\Entities\Employee $employee
     *
     * @return \Hourglass\Entities\TimesheetEntry
     */
    public function setEmployee(Employee $employee) : TimesheetEntry
    {
        $this->employee = $employee;
        return $this;
    }

    /**
     * @return \Hourglass\Entities\Job
     */
    public function getJob() : Job
    {
        return $this->job;
    }

    /**
     * @param \Hourglass\Entities\Job $job
     *
     * @return \Hourglass\Entities\TimesheetEntry
     */
    public function setJob(Job $job) : TimesheetEntry
    {
        $this->job = $job;
        return $this;
    }

    /**
     * @return \Hourglass\Entities\JobShift
     */
    public function getShift() : JobShift
    {
        return $this->shift;
    }

    /**
     * @param \Hourglass\Entities\JobShift $shift
     *
     * @return \Hourglass\Entities\TimesheetEntry
     */
    public function setShift(JobShift $shift) : TimesheetEntry
    {
        $this->shift = $shift;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStartTime() : DateTimeImmutable
    {
        return DateTimeUtils::toImmutable($this->start);
    }

    /**
     * @param \DateTimeInterface $start
     *
     * @return \Hourglass\Entities\TimesheetEntry
     */
    public function setStartTime(DateTimeInterface $start) : TimesheetEntry
    {
        $this->start = DateTimeUtils::toMutable($start);
        return $this;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getEndTime() : ?DateTimeImmutable
    {
        if (!$this->end) {
            return null;
        }
        return DateTimeUtils::toImmutable($this->end);
    }

    /**
     * @param \DateTimeInterface $end
     *
     * @return \Hourglass\Entities\TimesheetEntry
     */
    public function setEndTime(DateTimeInterface $end) : TimesheetEntry
    {
        $this->end = DateTimeUtils::toMutable($end);
        return $this;
    }



}
