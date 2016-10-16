<?php

namespace Hourglass\Http\Controllers\Api;

use Hourglass\Http\Requests\Employees\CreateEmployeeRequest;
use Hourglass\Http\Requests\Employees\RegisterTimecardRequest;
use Hourglass\Http\Requests\Employees\UpdateEmployeeRequest;
use Hourglass\Models\Employee;
use Hourglass\Transformers\EmployeeTransformer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use League\Fractal\Manager as FractalManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeController extends BaseController
{
    /**
     * EmployeeController constructor.
     *
     * @param \Illuminate\Contracts\Auth\Guard $guard
     * @param \League\Fractal\Manager $fractal
     * @param \Hourglass\Transformers\EmployeeTransformer $transformer
     */
    public function __construct(Guard $guard, FractalManager $fractal, EmployeeTransformer $transformer)
    {
        parent::__construct($guard, $fractal);
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->account->employees()
            ->with('location', 'agency')
            ->search($request->get('search'))
            ->sortTrashedLast()
            ->sort($request->get('sort_by'), $request->get('order'));

        if ($request->get('include_deleted')) {
            $query->withTrashed();
        }

        $paginate = $query->paginate($request->get('per_page', 10));

        return $this->respondWithPaginator($paginate);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Hourglass\Http\Requests\CreateEmployeeRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEmployeeRequest $request)
    {
        $employee = new Employee($request->only([
            'name', 'position', 'terminal_key',
        ]));
        $employee->location_id = $request->input('location.id');
        $employee->agency_id = $request->input('agency.id');
        $this->account->employees()->save($employee);

        return $this->respondWithItem($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /** @var Employee $employee */
        $employee = $this->account->employees()->find($id);

        if (!$employee) {
            throw new NotFoundHttpException('Not found.');
        }

        return $this->respondWithItem($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Hourglass\Http\Requests\UpdateEmployeeRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        /** @var Employee $employee */
        $employee = $this->account->employees()->find($id);

        if (!$employee) {
            throw new NotFoundHttpException('Not found.');
        }

        $employee->fill($request->only(['name', 'position', 'terminal_key']));
        $employee->location_id = $request->input('location.id');
        $employee->agency_id = $request->input('agency.id');
        $employee->save();

        $this->respondWithItem($employee);
    }

    /**
     * Register a timecard to an employee.
     *
     * @param  \Hourglass\Http\Requests\Employees\RegisterTimecardRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterTimecardRequest $request, $id)
    {
        /** @var Employee $employee */
        $employee = $this->account->employees()->find($id);
        if (!$employee) {
            throw new NotFoundHttpException('Not found.');
        }
        $terminalKey = $request->get('terminal_key');

        /** @var Employee $previouslyAssignedEmployee */
        $previouslyAssignedEmployee = $this->account->employees()
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
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /** @var Employee $employee */
        $employee = $this->account->employees()->find($id);

        if (!$employee) {
            throw new NotFoundHttpException('Not Found');
        }

        $employee->delete();
        return $this->respondWithItem($employee);
    }
}
