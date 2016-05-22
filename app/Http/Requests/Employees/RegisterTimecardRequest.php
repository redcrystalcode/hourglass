<?php

namespace Hourglass\Http\Requests\Employees;

use Hourglass\Http\Requests\Request;

class RegisterTimecardRequest extends Request
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
            'terminal_key' => 'required'
        ];
    }

    /**
     * Custom error messages
     * @return array
     */
    public function messages()
    {
        return [
            'terminal_key.required' => 'Please swipe a timecard to assign to an employee.'
        ];
    }


}
