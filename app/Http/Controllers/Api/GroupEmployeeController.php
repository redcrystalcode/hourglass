<?php
declare(strict_types = 1);

namespace Hourglass\Http\Controllers\Api;

use Hourglass\Http\Requests\Groups\AddEmployeeToGroupRequest;
use Hourglass\Models\Agency;
use Hourglass\Models\Employee;
use Hourglass\Transformers\EmployeeTransformer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GroupEmployeeController extends BaseController
{
	/**
	 * GroupEmployeeController constructor.
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
     * @param int $agencyId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(int $agencyId) : JsonResponse
    {
        $agency = $this->resolveAgency($agencyId);

        return $this->respondWithCollection($agency->employees);
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $agencyId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function available(int $agencyId) : JsonResponse
    {
        $agency = $this->resolveAgency($agencyId);

        $available = $this->resolveAccount($this->account)->employees()
            ->withTrashed()
            ->where(function(Builder $query) use ($agency) {
                return $query->where('agency_id', '!=', $agency->id)
                    ->orWhereNull('agency_id');
            })
            ->get();

        return $this->respondWithCollection($available);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Hourglass\Http\Requests\Groups\AddEmployeeToGroupRequest $request
     * @param int $agencyId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddEmployeeToGroupRequest $request, int $agencyId) : JsonResponse
    {
        /** @var Employee $employee */
        $employee = $this->resolveAccount($this->account)->employees()->find($request->get('employee_id'));

        $agency = $this->resolveAgency($agencyId);

        $agency->employees()->save($employee);

        return $this->respondWithItem($employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $agencyId
     * @param int $employeeId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $agencyId, int $employeeId) : JsonResponse
    {
        $agency = $this->resolveAgency($agencyId);

        /** @var Employee $employee */
        $employee = $agency->employees()->find($employeeId);
        if (!$employee) {
            throw new NotFoundHttpException('Not found.');
        }

        $employee->agency_id = null;
        $employee->save();

        return $this->respondWithItem($employee);
    }

    /**
     * @param int $id
     *
     * @return \Hourglass\Models\Agency
     */
    private function resolveAgency(int $id) : Agency
    {
        /** @var Agency $agency */
        $agency = $this->resolveAccount($this->account)->agencies()->find($id);

        if (!$agency) {
            throw new NotFoundHttpException('Not found.');
        }

        return $agency;
    }
}
