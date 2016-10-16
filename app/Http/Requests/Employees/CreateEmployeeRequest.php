<?php

namespace Hourglass\Http\Requests\Employees;

use Hourglass\Http\Requests\Request;
use RedCrystal\ValidationRules\ExistsValidationRule;
use RedCrystal\ValidationRules\UniqueValidationRule;

class CreateEmployeeRequest extends Request
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
            'terminal_key' => (new UniqueValidationRule('employees', 'terminal_key'))
                ->where('account_id', $accountId)
                ->whereNull('deleted_at')
                ->toString(),
            'location.id' => [
                'required',
                (new ExistsValidationRule('locations', 'id'))
                    ->where('account_id', $accountId)
                    ->toString(),
            ],
            'agency.id' => [
                (new ExistsValidationRule('agencies', 'id'))
                    ->where('account_id', $accountId)
                    ->toString()
            ]
        ];
    }
}
