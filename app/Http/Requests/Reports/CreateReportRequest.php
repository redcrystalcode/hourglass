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
        $accountId = $this->user()->getAccountId();

        $rules = [
            'type' => ['required', 'in:timesheet,agency,shift,job'],
        ];

        if ($this->get('type') === 'timesheet') {
            // Timesheet Report Rules
            return $rules + [
                'employee_id' => [
                    'required',
                    (new ExistsValidationRule('employees', 'id'))
                        ->where('account_id', $accountId)
                ],
                'start' => [
                    'required',
                    'date',
                ],
                'end' => [
                    'required',
                    'date',
                ],
            ];
        }

        if ($this->get('type') === 'agency') {
            // Agency Report Rules
            return $rules + [
                'agency_id' => [
                    'required',
                    (new ExistsValidationRule('agencies', 'id'))
                        ->where('account_id', $accountId)
                ],
                'start' => [
                    'required',
                    'date',
                ],
                'end' => [
                    'required',
                    'date',
                ],
            ];
        }

        if ($this->get('type') === 'shift') {
            // Shift Report Rules
            return $rules + [
                'job_shift_id' => [
                    'required',
                    (new ExistsValidationRule('job_shifts', 'id'))
                        ->where('account_id', $accountId)
                ],
            ];
        }

        if ($this->get('type') === 'job') {
            // Job Summary Report Rules
            return $rules + [
                'job_id' => [
                    'required',
                    (new ExistsValidationRule('jobs', 'id'))
                        ->where('account_id', $accountId)
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
            'employee_id.required' => 'Select an employee to create the report.',
            'agency_id.required' => 'Select an agency to create the report.',
            'start.required' => 'Select a valid start date.',
            'end.required' => 'Select a valid end date.',
            'job_id.required' => 'Select a job to create the report.',
            'job_shift_id.required' => 'Select a job shift to create the report.',
        ];
    }


}
