<?php

namespace Hourglass\Http\Requests\Groups;

use Hourglass\Http\Requests\Request;
use Hourglass\Models\Account;
use RedCrystal\ValidationRules\ExistsValidationRule;

class AddEmployeeToGroupRequest extends Request
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
        /** @var Account $account */
        $account = $this->user()->account;
        return [
            'employee_id' => (new ExistsValidationRule('employees', 'id'))
                ->where('account_id', $account->id)
                ->toString(),
        ];
    }
}
