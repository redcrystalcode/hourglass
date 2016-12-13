<?php
declare(strict_types = 1);
namespace Hourglass\Entities;

use Hourglass\Entities\Behaviors\BelongsToAccount;
use Hourglass\Entities\Behaviors\ImmutableTimestamps;
use Ramsey\Uuid\Uuid;

class Report
{
    use BelongsToAccount, ImmutableTimestamps;

    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $note;

    /** @var string */
    private $type;

    /** @var array */
    private $parameters;

    /**
     * Report constructor.
     *
     * @param string $name
     * @param string $note
     * @param string $type
     * @param array $parameters
     */
    public function __construct(string $name, string $note, string $type, array $parameters)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->name = $name;
        $this->note = $note;
        $this->type = $type;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return \Hourglass\Entities\Report
     */
    public function setName(string $name) : Report
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getNote() : string
    {
        return $this->note;
    }

    /**
     * @param string $note
     *
     * @return \Hourglass\Entities\Report
     */
    public function setNote(string $note) : Report
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return \Hourglass\Entities\Report
     */
    public function setType(string $type) : Report
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return array
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     *
     * @return \Hourglass\Entities\Report
     */
    public function setParameters(array $parameters) : Report
    {
        $this->parameters = $parameters;
        return $this;
    }
}
