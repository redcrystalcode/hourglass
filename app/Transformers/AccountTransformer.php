<?php
declare(strict_types = 1);

namespace Hourglass\Transformers;

use Hourglass\Entities\Account;

class AccountTransformer extends Transformer
{
    /**
     * @param \Hourglass\Entities\Account $account
     *
     * @return array
     */
    public function transform(Account $account) : array
    {
        return [
            'id' => $account->getId(),
            'name' => $account->getName(),
        ];
    }
}
