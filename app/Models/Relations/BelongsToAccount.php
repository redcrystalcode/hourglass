<?php
namespace Hourglass\Models\Relations;

use Hourglass\Models\Account;

trait BelongsToAccount
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @param Account $account
     *
     * @return $this
     */
    public function setAccount(Account $account)
    {
        if ($this->exists) {
            trigger_error(
                "A model's account association should only be modified on models that have not been saved yet.",
                E_USER_WARNING
            );
        }

        $this->account_id = $account->id;

        return $this;
    }
}
