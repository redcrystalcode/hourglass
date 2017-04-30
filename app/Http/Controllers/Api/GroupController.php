<?php
declare(strict_types = 1);

namespace Hourglass\Http\Controllers\Api;

use Doctrine\ORM\EntityManagerInterface as EntityManager;
use Hourglass\Http\Requests\Groups\CreateGroupRequest;
use Hourglass\Http\Requests\Groups\UpdateGroupRequest;
use Hourglass\Models\Agency;
use Hourglass\Transformers\AgencyTransformer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Manager as FractalManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GroupController extends BaseController
{
	/**
	 * AgencyController constructor.
	 *
	 * @param \Doctrine\ORM\EntityManagerInterface $em
	 * @param \Illuminate\Contracts\Auth\Guard $guard
	 * @param \League\Fractal\Manager $fractal
	 * @param \Hourglass\Transformers\AgencyTransformer $transformer
	 */
	public function __construct(
		EntityManager $em,
		Guard $guard,
		FractalManager $fractal,
		AgencyTransformer $transformer
	) {
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
        $paginate = $this->resolveAccount($this->account)->agencies()
            ->search($request->get('search'))
            ->sort($request->get('sort_by'), $request->get('order'))
            ->paginate($request->get('per_page', 10));

        return $this->respondWithPaginator($paginate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Hourglass\Http\Requests\Groups\CreateGroupRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateGroupRequest $request) : JsonResponse
    {
        $agencies = new Agency($request->only(['name']));
        $this->resolveAccount($this->account)->agencies()->save($agencies);

        return $this->respondWithItem($agencies);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id) : JsonResponse
    {
        /** @var Agency $agency */
        $agency = $this->resolveAccount($this->account)->agencies()->find($id);

        if (!$agency) {
            throw new NotFoundHttpException('Not found.');
        }

        return $this->respondWithItem($agency);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Hourglass\Http\Requests\Groups\UpdateGroupRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateGroupRequest $request, int $id) : JsonResponse
    {
        /** @var Agency $agency */
        $agency = $this->resolveAccount($this->account)->agencies()->find($id);

        if (!$agency) {
            throw new NotFoundHttpException('Not found.');
        }

        $agency->fill($request->only(['name']));
        $agency->save();

        $this->respondWithItem($agency);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 *
	 * @throws \Exception
	 */
    public function destroy(int $id)
    {
        // TODO - Allow deleting an agency.
        throw new \Exception('Cannot delete agency.');
        /** @var Agency $agency */
        $agency = $this->resolveAccount($this->account)->agencies()->find($id);

        if (!$agency) {
            throw new NotFoundHttpException('Not found.');
        }

        $agency->delete();
    }
}
