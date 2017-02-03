<?php

namespace Hourglass\Http\Requests\Jobs;

use Hourglass\Http\Requests\Request;
use RedCrystal\ValidationRules\ExistsValidationRule;

class CreateJobRequest extends Request
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
        $accountId = $this->user()->account_id;
        return [
            'name' => 'required',
            'number' => 'required',
            'customer' => 'required',
            'location.id' => [
                'required',
                (new ExistsValidationRule('locations', 'id'))
                    ->where('account_id', $accountId)
                    ->toString()
            ],
            'productivity.type' => [
                'required',
                'in:quantity,none'
            ],
            'productivity.quantity' => [
                'integer',
                'required_if:productivity.type,quantity'
            ],
            'productivity.employees' => [
                'integer',
                'required_if:productivity.type,quantity'
            ]
        ];
    }

    /**
     * Custom validator error messages
     * @return array
     */
    public function messages()
    {
        return [
            'location_id.required' => [
                'Please select a location.'
            ],
            'productivity.type.required' => [
                'Please select a productivity type.'
            ],
            'productivity.type.in' => [
                'Please select a valid productivity type.'
            ],
            'productivity.quantity.required_if' => [
                'Projected Quantity Per Hour is required.'
            ],
            'productivity.quantity.integer' => [
                'Projected Quantity Per Hour must be a number.'
            ],
            'productivity.employees.required_if' => [
                'Projected Quantity Per Hour is required.'
            ],
            'productivity.employees.integer' => [
                'Projected Quantity Per Hour must be a number.'
            ],
        ];
    }
}
