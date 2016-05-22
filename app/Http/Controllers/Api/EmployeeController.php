<?php

namespace Hourglass\Http\Controllers\Api;

use Hourglass\Http\Controllers\Controller;
use Hourglass\Http\Requests;
use Hourglass\Http\Requests\CreateEmployeeRequest;
use Hourglass\Models\Employee;
use Hourglass\Transformers\EmployeeTransformer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class EmployeeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate = $this->account->employees()
            ->search($request->get('search'))
            ->sort($request->get('sort_by'), $request->get('order'))
            ->paginate($request->get('per_page', 50));

        return $this->respondWithPaginator($paginate, new EmployeeTransformer());
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
        $employee = new Employee();
        $employee->name = $request->get('name');
        $employee->position = $request->get('position');
        $employee->terminal_key = $request->get('terminal_key');
        $employee->location_id = $request->get('location_id');
        $this->account->employees()->save($employee);

        return $employee;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        //
    }
}
