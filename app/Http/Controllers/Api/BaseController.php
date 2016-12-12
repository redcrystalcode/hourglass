<?php

namespace Hourglass\Http\Controllers\Api;

use Hourglass\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Hourglass\Transformers\Transformer;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
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
     * @var \Hourglass\Models\User
     */
    protected $user;

    /**
     * @var \Hourglass\Models\Account
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
     * EmployeesController constructor.
     *
     * @param \Illuminate\Contracts\Auth\Guard $guard
     * @param \League\Fractal\Manager $fractal
     */
    public function __construct(Guard $guard, FractalManager $fractal)
    {
        $this->guard = $guard;
        $this->user = $this->resolveUser($this->guard->user());
        $this->account = $this->user->account;
        $this->fractal = $fractal;
    }

    /**
     * @param $item
     * @param \Hourglass\Transformers\Transformer|null $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithItem($item, Transformer $transformer = null)
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
    protected function respondWithCollection($collection, Transformer $transformer = null)
    {
        $transformer = $transformer ?: $this->transformer;

        $resource = new FractalCollection($collection, $transformer);
        $rootScope = $this->fractal->createData($resource);

        return $this->respondWithArray($rootScope->toArray());
    }

    /**
     * @param Paginator $paginator
     * @param null $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithPaginator(Paginator $paginator, $transformer = null)
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
    protected function respondWithArray(array $array, array $headers = [])
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
}
