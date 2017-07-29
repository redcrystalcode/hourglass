<?php
declare(strict_types = 1);

namespace Hourglass\Providers;

use Doctrine\ORM\EntityManagerInterface;
use Hourglass\Entities\Account;
use Hourglass\Repositories\AccountRepository;
use Hourglass\Repositories\Database\AccountRepository as DbAccountRepository;
use Illuminate\Support\ServiceProvider;

class DoctrineServiceProvider extends ServiceProvider
{
	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(AccountRepository::class, function () {
			$em = $this->app->make(EntityManagerInterface::class);
			return new DbAccountRepository($em, $em->getRepository(Account::class));
		});
	}
}
