<?php

namespace Hourglass\Models;

use Hourglass\Models\Behaviors\HasUuid;
use Hourglass\Models\Relations\BelongsToAccount;
use Hourglass\Models\Scopes\IsSearchable;
use Hourglass\Models\Scopes\IsSortable;
use Illuminate\Database\Eloquent\Model;

/**
 * Hourglass\Models\Report
 *
 * @property string $id
 * @property integer $account_id
 * @property string $name
 * @property string $note
 * @property string $type
 * @property mixed $parameters
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Hourglass\Models\Account $account
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Report whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Report whereAccountId($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Report whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Report whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Report whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Report whereParameters($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Report search($keyword)
 * @method static \Illuminate\Database\Query\Builder|\Hourglass\Models\Report sort($column, $direction)
 * @mixin \Eloquent
 */
class Report extends Model
{
    use BelongsToAccount, IsSearchable, IsSortable, HasUuid;

    protected $fillable = ['name', 'note', 'type', 'parameters'];

    protected $sortable = ['name', 'created_at'];

    protected $searchable = ['name'];

    protected $casts = [
        'parameters' => 'array'
    ];

    public function generateName()
    {
        if ($this->type === 'timesheet') {
            /** @var Employee $employee */
            $employee = Employee::withTrashed()->findOrFail($this->parameters['employee_id']);
            $this->name = "{$employee->name} - {$this->parameters['start']} to {$this->parameters['end']}";
        } elseif ($this->type === 'shift') {
            /** @var JobShift $shift */
            $shift = JobShift::with('job')->findOrFail($this->parameters['job_shift_id']);
            $start = $shift->created_at->format('D, M d, Y');
            $this->name = "#{$shift->job->number} Shift Report - {$start}";
        }
    }
}
