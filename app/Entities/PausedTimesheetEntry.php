<?php
declare(strict_types = 1);
namespace Hourglass\Entities;

use Hourglass\Entities\Behaviors\BelongsToAccount;
use Hourglass\Entities\Behaviors\ImmutableTimestamps;

class PausedTimesheetEntry
{
    use BelongsToAccount, ImmutableTimestamps;

    /** @var int */
    private $id;

    /** @var \Hourglass\Entities\Employee */
    private $employee;

    /** @var \Hourglass\Entities\JobShift */
    private $shift;

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
     * @return \Hourglass\Entities\PausedTimesheetEntry
     */
    public function setEmployee(Employee $employee) : PausedTimesheetEntry
    {
        $this->employee = $employee;
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
     * @return \Hourglass\Entities\PausedTimesheetEntry
     */
    public function setShift(JobShift $shift) : PausedTimesheetEntry
    {
        $this->shift = $shift;
        return $this;
    }
}
