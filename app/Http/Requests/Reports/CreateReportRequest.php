<?php

namespace Hourglass\Http\Requests\Reports;

use Hourglass\Http\Requests\Request;
use RedCrystal\ValidationRules\ExistsValidationRule;

class CreateReportRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => ['required', 'in:timesheet,shift,job'],
            // Timesheet Report Rules
            'employee_id' => [
                'required_if:type,timesheet',
                (new ExistsValidationRule('employees', 'id'))
                    ->where('account_id', $this->user()->account_id)
            ],
            'start' => [
                'required_if:type,timesheet',
                'date',
            ],
            'end' => [
                'required_if:type,timesheet',
                'date',
            ],
        ];
    }
}
