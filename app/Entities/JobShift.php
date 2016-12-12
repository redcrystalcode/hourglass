<?php
declare(strict_types = 1);
namespace Hourglass\Entities;

use Hourglass\Entities\Behaviors\BelongsToAccount;
use Hourglass\Entities\Behaviors\ImmutableTimestamps;

class JobShift
{
    use BelongsToAccount, ImmutableTimestamps;

    /** @var int */
    private $id;

    /** @var \Hourglass\Entities\Job */
    private $job;

    /** @var array */
    private $productivity;

    /** @var string */
    private $comment;

    /** @var bool */
    private $closed;

    /** @var bool */
    private $paused;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
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
     * @return \Hourglass\Entities\JobShift
     */
    public function setJob(Job $job) : JobShift
    {
        $this->job = $job;
        return $this;
    }

    /**
     * @return array
     */
    public function getProductivity() : array
    {
        return $this->productivity;
    }

    /**
     * @param array $productivity
     *
     * @return \Hourglass\Entities\JobShift
     */
    public function setProductivity(array $productivity) : JobShift
    {
        $this->productivity = $productivity;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment() : string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     *
     * @return \Hourglass\Entities\JobShift
     */
    public function setComment(string $comment) : JobShift
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isClosed() : bool
    {
        return $this->closed;
    }

    /**
     * @return \Hourglass\Entities\JobShift
     */
    public function close() : JobShift
    {
        $this->closed = true;
        return $this;
    }

    /**
     * @return \Hourglass\Entities\JobShift
     */
    public function reopen() : JobShift
    {
        $this->closed = false;
    }

    /**
     * @return boolean
     */
    public function isPaused() : bool
    {
        return $this->paused;
    }

    /**
     * @return \Hourglass\Entities\JobShift
     */
    public function pause() : JobShift
    {
        $this->paused = true;
        return $this;
    }

    /**
     * @return \Hourglass\Entities\JobShift
     */
    public function resume() : JobShift
    {
        $this->paused = false;
        return $this;
    }

}
