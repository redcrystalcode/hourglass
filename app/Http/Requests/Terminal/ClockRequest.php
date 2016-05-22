<?php

namespace Hourglass\Http\Requests\Terminal;

use Hourglass\Http\Requests\Request;
use RedCrystal\ValidationRules\ExistsValidationRule;

class ClockRequest extends Request
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
            'terminal_key' => [
                'required',
                (new ExistsValidationRule('employees', 'terminal_key'))
                    ->where('account_id', $this->user()->account_id)
                    ->whereNull('deleted_at')
                    ->toString()
            ],
            'job_id' => [
                (new ExistsValidationRule('jobs', 'id'))
                    ->where('account_id', $this->user()->account_id)
                    ->whereNull('deleted_at')
                    ->toString()
            ],
        ];
    }

    /**
     * Custom validator error messages
     * @return array
     */
    public function messages()
    {
        return [
            'terminal_key.required' => 'Please swipe your timecard.',
            'terminal_key.exists' => "No employee found with this timecard. "
                . "Try registering it to someone by clicking 'Register Timecard' below.",
        ];
    }


}
