<?php
declare(strict_types = 1);

namespace Hourglass\Http\Middleware;

use Closure;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Illuminate\Http\Request;

class FlushEntityManager
{
	/**
	 * @var \Doctrine\ORM\EntityManagerInterface
	 */
	private $em;

	/**
	 * FlushEntityManager constructor.
	 *
	 * @param \Doctrine\ORM\EntityManagerInterface $em
	 */
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
		$response = $next($request);

		$this->em->flush();

		return $response;
    }
}
