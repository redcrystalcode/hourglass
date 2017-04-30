<?php
declare(strict_types = 1);

namespace Hourglass\Repositories\Database;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Hourglass\Entities\Account;
use Hourglass\Repositories\AccountRepository as AccountRepositoryContract;

class AccountRepository implements AccountRepositoryContract
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $repo;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * AccountRepository constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $em
     * @param \Doctrine\Common\Persistence\ObjectRepository $repo
     */
    public function __construct(EntityManager $em, ObjectRepository $repo)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
     * Find an Account by ID.
     *
     * @param int $id
     *
     * @return \Hourglass\Entities\Account|null
     */
    public function find(int $id) : ?Account
    {
        $account = $this->repo->find($id);

        if ($account !== null || !($account instanceof Account)) {
            return null;
        }

        return $account;
    }

    /**
     * Add a new Account to the data store.
     *
     * @param \Hourglass\Entities\Account $account
     */
    public function add(Account $account) : void
    {
        $this->em->persist($account);
    }

    /**
     * Update an existing account in the data store.
     *
     * @param \Hourglass\Entities\Account $account
     */
    public function update(Account $account) : void
    {
        $this->em->persist($account);
    }


    /**
     * Remove an existing account from the data store.
     *
     * @param \Hourglass\Entities\Account $account
     */
    public function remove(Account $account) : void
    {
        $this->em->remove($account);
    }
}
