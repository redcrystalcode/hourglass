<?php
declare(strict_types = 1);

namespace Hourglass\Http\Controllers\Api;

use Hourglass\Http\Requests\Employees\CreateEmployeeRequest;
use Hourglass\Http\Requests\Employees\RegisterTimecardRequest;
use Hourglass\Http\Requests\Employees\UpdateEmployeeRequest;
use Hourglass\Models\Employee as EloquentEmployee;
use Hourglass\Models\Employee;
use Hourglass\Transformers\EmployeeTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeController extends BaseController
{
	/**
	 * EmployeeController constructor.
	 *
	 * @param \Hourglass\Transformers\EmployeeTransformer $transformer
	 */
	public function __construct(EmployeeTransformer $transformer)
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
        $query = $this->resolveAccount($this->account)->employees()
            ->with('location', 'agency')
            ->search($request->get('search'))
            ->sortTrashedLast()
            ->sort($request->get('sort_by'), $request->get('order'));

        if ($request->get('include_deleted')) {
            $query->withTrashed();
        }

        if ($request->get('per_page')) {
            $paginate = $query->paginate($request->get('per_page', 10));
            return $this->respondWithPaginator($paginate);
        }

        return $this->respondWithCollection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Hourglass\Http\Requests\Employees\CreateEmployeeRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateEmployeeRequest $request) : JsonResponse
    {
        $employee = new EloquentEmployee($request->only([
            'name', 'position', 'terminal_key',
        ]));
        $employee->location_id = $request->input('location.id');
        $employee->agency_id = $request->input('agency.id');

		$this->resolveAccount($this->account)->employees()->save($employee);

        return $this->respondWithItem($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) : JsonResponse
    {
        $employee = $this->resolveAccount($this->account)->employees()->find($id);

        if (!$employee) {
            throw new NotFoundHttpException('Not found.');
        }

        return $this->respondWithItem($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Hourglass\Http\Requests\Employees\UpdateEmployeeRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateEmployeeRequest $request, $id) : JsonResponse
    {
		/** @var EloquentEmployee $employee */
		$employee = $this->resolveAccount($this->account)->employees()->find($id);

        if (!$employee) {
            throw new NotFoundHttpException('Not found.');
        }

        $employee->fill($request->only(['name', 'position', 'terminal_key']));
        $employee->location_id = $request->input('location.id');
        $employee->agency_id = $request->input('agency.id');
        $employee->save();

        return $this->respondWithItem($employee);
    }

    /**
     * Register a timecard to an employee.
     *
     * @param \Hourglass\Http\Requests\Employees\RegisterTimecardRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterTimecardRequest $request, int $id) : JsonResponse
    {
		/** @var EloquentEmployee $employee */
		$employee = $this->resolveAccount($this->account)->employees()->find($id);

        if (!$employee) {
            throw new NotFoundHttpException('Not found.');
        }
        $terminalKey = $request->get('terminal_key');

        /** @var EloquentEmployee $previouslyAssignedEmployee */
        $previouslyAssignedEmployee = $this->resolveAccount($this->account)->employees()
            ->where('terminal_key', $terminalKey)->first();

        // Disassociate timecard from previous employee.
        if ($previouslyAssignedEmployee) {
            $previouslyAssignedEmployee->terminal_key = null;
            $previouslyAssignedEmployee->save();
        }

        $employee->terminal_key = $terminalKey;
        $employee->save();

        return $this->respondWithItem($employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id) : JsonResponse
    {
		/** @var EloquentEmployee $employee */
		$employee = $this->resolveAccount($this->account)->employees()->find($id);

        if (!$employee) {
            throw new NotFoundHttpException('Not Found');
        }

        $employee->delete();
        return $this->respondWithItem($employee);
    }
}
