<?php
namespace Hourglass\Models\Scopes;

trait SortsTrashedLast
{
    public function scopeSortTrashedLast($query)
    {
        return $query->orderBy(\DB::raw('NOT ISNULL(deleted_at)'));
    }
}
