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
            'terminal_key' => $employee->terminal_key
        ];
    }
}
