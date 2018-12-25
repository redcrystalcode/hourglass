<?php

namespace Hourglass\Http\Requests\RoundingRules;

use Hourglass\Http\Requests\Request;
use RedCrystal\ValidationRules\ExistsValidationRule;

class CreateTimesheetRequest extends Request
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
            'employee_id' => [
                'required',
                (new ExistsValidationRule('employees', 'id'))
                    ->where('account_id', $this->user()->getAccountId())
                    ->whereNull('deleted_at')
                    ->toString()
            ],
            'time_in' => ['required', 'date'],
            'time_out' => ['required', 'date'],
            'criteria' => 'required',
            'resolution' => ['required', 'date_format:g:i a'],
        ];
    }

    /**
     * Custom validator error messages
     * @return array
     */
    public function messages()
    {
        return [
            'start.required' => [
                'Please enter a start time.'
            ],
            'start.date_format' => [
                'Please enter a valid start time. (e.g. 7:01 am)'
            ],
            'end.required' => [
                'Please enter an end time.'
            ],
            'end.date_format' => [
                'Please enter a valid end time. (e.g. 7:04 am)'
            ],
            'criteria.required' => [
                'Please select a criteria for this rule.'
            ],
            'resolution.required' => [
                'Please enter the desired rounded time.'
            ],
            'resolution.date_format' => [
                'Please enter a valid rounding time. (e.g. 7:00 am)'
            ],
        ];
    }
}
