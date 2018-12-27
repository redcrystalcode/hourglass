<?php

namespace Hourglass\Http\Requests\Timesheets;

use Hourglass\Http\Requests\Request;
use RedCrystal\ValidationRules\ExistsValidationRule;

class UpdateTimesheetRequest extends Request
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->request->set('time_in', strtolower($this->get('time_in')));
        $this->request->set('time_out', strtolower($this->get('time_out')));
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
            'job_id' => [
                'required',
                (new ExistsValidationRule('jobs', 'id'))
                    ->where('account_id', $this->user()->getAccountId())
                    ->whereNull('deleted_at')
                    ->toString()
            ],
            'time_in' => ['required', 'date_format:g:i a'],
            'time_out' => ['required', 'date_format:g:i a'],
            'date' => ['required', 'date'],
        ];
    }

    /**
     * Custom validator error messages
     * @return array
     */
    public function messages()
    {
        return [
            'time_in.required' => [
                'Please enter a start time.'
            ],
            'time_in.date_format' => [
                'Please enter a valid start time. (e.g. 7:01 am)'
            ],
            'time_out.required' => [
                'Please enter an end time.'
            ],
            'time_out.date_format' => [
                'Please enter a valid end time. (e.g. 11:04 pm)'
            ],
            'date.required' => [
                'Please choose a date.'
            ],
            'date.date_format' => [
                'Please choose a valid date.'
            ],
        ];
    }
}
