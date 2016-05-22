<?php
namespace Hourglass\Models\Scopes;

use Hourglass\Exceptions\InvalidUsageException;

trait IsSearchable
{
    public function scopeSearch($query, $keyword)
    {
        if (!property_exists($this, 'searchable') || !is_array($this->searchable) || count($this->searchable) === 0) {
            throw new InvalidUsageException('No searchable fields defined on the model.');
        }

        $keyword = '%' . $keyword . '%';
        return $query->where(function($query) use ($keyword) {
            foreach ($this->searchable as $index => $key) {
                if ($index === 0) {
                    $query->where($key, 'LIKE', $keyword);
                } else {
                    $query->orWhere($key, 'LIKE', $keyword);
                }
            }
        });
    }
}
