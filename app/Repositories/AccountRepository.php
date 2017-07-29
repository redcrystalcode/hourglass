<?php
declare(strict_types = 1);

namespace Hourglass\Repositories;

use Hourglass\Entities\Account;

interface AccountRepository
{
	/**
	 * Find an Account by ID.
	 *
	 * @param int $id
	 *
	 * @return \Hourglass\Entities\Account|null
	 */
    public function find(int $id) : ?Account;

	/**
	 * Add a new Account to the data store.
	 *
	 * @param \Hourglass\Entities\Account $account
	 */
	public function add(Account $account) : void;

	/**
	 * Update an existing account in the data store.
	 *
	 * @param \Hourglass\Entities\Account $account
	 */
	public function update(Account $account) : void;

	/**
	 * Remove an existing account from the data store.
	 *
	 * @param \Hourglass\Entities\Account $account
	 */
	public function remove(Account $account) : void;
}
