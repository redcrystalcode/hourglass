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

    /** @var \Hourglass\Entities\TimesheetEntry */
    private $entry;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return \Hourglass\Entities\TimesheetEntry
     */
    public function getTimesheetEntry() : TimesheetEntry
    {
        return $this->entry;
    }

    /**
     * @param \Hourglass\Entities\TimesheetEntry $entry
     *
     * @return \Hourglass\Entities\PausedTimesheetEntry
     */
    public function setTimesheetEntry(TimesheetEntry $entry) : PausedTimesheetEntry
    {
        $this->entry = $entry;
        return $this;
    }

}
