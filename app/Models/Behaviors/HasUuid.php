<?php

namespace Hourglass\Models\Behaviors;

use Ramsey\Uuid\Uuid;

trait HasUuid
{
    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Disable the auto-increment assumption for the Model;
        $this->incrementing = false;

        $this->setUuidIfNotSet();
    }

    protected function setUuidIfNotSet()
    {
        if (!is_null($this->id)) {
            return;
        }

        // Generate a UUID instantly on Model instantiation.
        $this->id = Uuid::uuid4()->toString();
    }
}
