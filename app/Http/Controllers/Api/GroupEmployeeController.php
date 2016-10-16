<?php
namespace Hourglass\Http\Controllers\Api;

use Hourglass\Http\Requests\Groups\AddEmployeeToGroupRequest;
use Hourglass\Models\Agency;
use Hourglass\Models\Employee;
use Hourglass\Transformers\EmployeeTransformer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Builder;
use League\Fractal\Manager as FractalManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GroupEmployeeController extends BaseController
{
    /**
     * GroupEmployeeController constructor.
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
     * @param int $agencyId
     *
     * @return \Illuminate\Http\Response
     */
    public function index($agencyId)
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
    public function available($agencyId)
    {
        $agency = $this->resolveAgency($agencyId);
        
        $available = $this->account->employees()
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
     * @return \Illuminate\Http\Response
     */
    public function store(AddEmployeeToGroupRequest $request, $agencyId)
    {
        /** @var Employee $employee */
        $employee = $this->account->employees()->find($request->get('employee_id'));
        
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($agencyId, $employeeId)
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
    private function resolveAgency($id)
    {
        /** @var Agency $agency */
        $agency = $this->account->agencies()->find($id);
        
        if (!$agency) {
            throw new NotFoundHttpException('Not found.');
        }
        
        return $agency;
    }
}
