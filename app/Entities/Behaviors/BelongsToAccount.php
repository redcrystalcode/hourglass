<?php
declare(strict_types = 1);
namespace Hourglass\Entities\Behaviors;

use Hourglass\Entities\Account;

trait BelongsToAccount
{
    /** @var \Hourglass\Entities\Account */
    private $account;

    /**
     * @return \Hourglass\Entities\Account
     */
    public function getAccount() : Account
    {
        return $this->account;
    }

    /** @noinspection PhpDocSignatureInspection */
    /**
     * @param \Hourglass\Entities\Account $account
     *
     * @return $this
     */
    public function setAccount(Account $account) : self
    {
        $this->account = $account;
        return $this;
    }
}
