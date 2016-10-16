<?php
namespace Hourglass\Transformers;

use Hourglass\Models\Employee;

class EmployeeTransformer extends Transformer
{
    public function transform(Employee $employee) : array
    {
        return [
            'id' => $employee->id,
            'name' => $employee->name,
            'position' => $employee->position,
            'terminal_key' => $employee->terminal_key,
            'archived' => $employee->trashed(),
            'location' => [
                'id' => $employee->location->id,
                'name' => $employee->location->name,
            ],
            'agency' => $employee->agency ? [
                'id' => $employee->agency->id,
                'name' => $employee->agency->name
            ] : null,
        ];
    }
}
