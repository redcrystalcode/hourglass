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
        $rules = [
            'type' => ['required', 'in:timesheet,agency,shift,job'],
        ];

        if ($this->get('type') === 'timesheet') {
            // Timesheet Report Rules
            return $rules + [
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

        if ($this->get('type') === 'agency') {
            // Agency Report Rules
            return $rules + [
                'agency_id' => [
                    'required_if:type,agency',
                    (new ExistsValidationRule('agencies', 'id'))
                        ->where('account_id', $this->user()->account_id)
                ],
                'start' => [
                    'required_if:type,agency',
                    'date',
                ],
                'end' => [
                    'required_if:type,agency',
                    'date',
                ],
            ];
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'employee_id.required_if' => 'Select an employee to create the report.',
            'agency_id.required_if' => 'Select an agency to create the report.',
            'start.required_if' => 'Select a valid start date.',
            'end.required_if' => 'Select a valid end date.',
        ];
    }


}
