<?php
namespace Hourglass\Transformers;

use Hourglass\Models\Account;

class AccountTransformer extends Transformer
{
    /**
     * @param \Hourglass\Models\Account $account
     *
     * @return array
     */
    public function transform(Account $account) : array
    {
        return [
            'id' => $account->id,
            'name' => $account->name
        ];
    }
}
