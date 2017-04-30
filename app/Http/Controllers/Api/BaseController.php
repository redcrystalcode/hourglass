<?php
declare(strict_types = 1);

namespace Hourglass\Http\Controllers\Api;

use Auth;
use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Hourglass\Entities\Account;
use Hourglass\Http\Controllers\Controller;
use Hourglass\Models\Account as EloquentAccount;
use Hourglass\Models\User as EloquentUser;
use Hourglass\Transformers\Transformer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use League\Fractal\Manager as FractalManager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Resource\Item as FractalItem;

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
	 */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->account = $this->user->getAccount();

            return $next($request);
        });

        $this->fractal = app(FractalManager::class);
		$this->em = app(EntityManager::class);
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
