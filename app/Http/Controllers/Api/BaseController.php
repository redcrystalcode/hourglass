<?php
declare(strict_types = 1);

namespace Hourglass\Http\Controllers\Api;

use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Hourglass\Entities\Account;
use Hourglass\Models\Account as EloquentAccount;
use Hourglass\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Hourglass\Transformers\Transformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use League\Fractal\Manager as FractalManager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Resource\Item as FractalItem;
use Hourglass\Models\User as EloquentUser;

class BaseController extends Controller
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $guard;

    /**
     * @var \Hourglass\Entities\User
     */
    protected $user;

    /**
     * @var \Hourglass\Entities\Account
     */
    protected $account;

    /**
     * @var \League\Fractal\Manager
     */
    protected $fractal;

    /**
     * @var \Hourglass\Transformers\Transformer
     */
    protected $transformer;
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $em;

	/**
	 * EmployeesController constructor.
	 *
	 * @param \Doctrine\ORM\EntityManagerInterface $em
	 * @param \Illuminate\Contracts\Auth\Guard $guard
	 * @param \League\Fractal\Manager $fractal
	 */
    public function __construct(EntityManager $em, Guard $guard, FractalManager $fractal)
    {
        $this->guard = $guard;
        $this->user = $this->guard->user();
        $this->account = $this->user->getAccount();
        $this->fractal = $fractal;
		$this->em = $em;
	}

    /**
     * @param $item
     * @param \Hourglass\Transformers\Transformer|null $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithItem($item, Transformer $transformer = null) : JsonResponse
    {
        $transformer = $transformer ?: $this->transformer;

        $resource = new FractalItem($item, $transformer);
        $rootScope = $this->fractal->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     * @param $collection
     * @param \Hourglass\Transformers\Transformer|null $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithCollection($collection, Transformer $transformer = null) : JsonResponse
    {
        $transformer = $transformer ?: $this->transformer;

        $resource = new FractalCollection($collection, $transformer);
        $rootScope = $this->fractal->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     * @param Paginator $paginator
     * @param Transformer|null $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithPaginator(Paginator $paginator, Transformer $transformer = null) : JsonResponse
    {
        $collection = $paginator->getCollection();

        $transformer = $transformer ?: $this->transformer;
        $resource = new FractalCollection($collection, $transformer);

        // Append all other query params to the paginator.
        $paginator->appends(request()->except('page'));

        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        $rootScope = $this->fractal->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     * @param array $array
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithArray(array $array, array $headers = []) : JsonResponse
    {
        $response = response()->json($array, 200, $headers);
        return $response;
    }

    /**
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return \Hourglass\Models\User
     */
    protected function resolveUser(Authenticatable $user) : EloquentUser
    {
        return EloquentUser::find($user->getAuthIdentifier());
    }

    /**
     * @param \Hourglass\Entities\Account $account
     *
     * @return \Hourglass\Models\Account
     */
    protected function resolveAccount(Account $account) : EloquentAccount
    {
        return EloquentAccount::find($account->getId());
    }
}
