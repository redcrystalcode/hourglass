<?php
declare(strict_types = 1);

namespace Hourglass\Http\Controllers\Api;

use Hourglass\Transformers\LocationTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController extends BaseController
{
	/**
	 * AgencyController constructor.
	 *
	 * @param \Hourglass\Transformers\LocationTransformer $transformer
	 */
    public function __construct(LocationTransformer $transformer)
    {
        parent::__construct();
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
