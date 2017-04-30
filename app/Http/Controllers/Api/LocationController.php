<?php
declare(strict_types = 1);

namespace Hourglass\Http\Controllers\Api;

use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Hourglass\Transformers\LocationTransformer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Manager as FractalManager;

class LocationController extends BaseController
{
	/**
	 * AgencyController constructor.
	 *
	 * @param \Doctrine\ORM\EntityManagerInterface $em
	 * @param \Illuminate\Contracts\Auth\Guard $guard
	 * @param \League\Fractal\Manager $fractal
	 * @param \Hourglass\Transformers\LocationTransformer $transformer
	 */
    public function __construct(EntityManager $em, Guard $guard, FractalManager $fractal, LocationTransformer $transformer)
    {
        parent::__construct($em, $guard, $fractal);
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $paginate = $this->resolveAccount($this->account)->locations()
            ->search($request->get('search'))
            ->sort($request->get('sort_by'), $request->get('order'))
            ->paginate($request->get('per_page', 10));

        return $this->respondWithPaginator($paginate);
    }
}
