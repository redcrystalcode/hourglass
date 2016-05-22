<?php
namespace Hourglass\Models\Scopes;

use Hourglass\Exceptions\InvalidUsageException;

trait IsSortable
{
    public function scopeSort($query, $column, $direction)
    {
        if (!property_exists($this, 'sortable') || !is_array($this->sortable) || count($this->sortable) === 0) {
            throw new InvalidUsageException('No sortable fields defined on the model.');
        }

        if (!in_array($column, $this->sortable)) {
            return $query;
        }

        return $query->orderBy($column, $direction);
    }
}
