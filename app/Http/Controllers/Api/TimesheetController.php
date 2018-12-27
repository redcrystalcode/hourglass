<?php
declare(strict_types=1);

namespace Hourglass\Http\Controllers\Api;

use Carbon\Carbon;
use Hourglass\Http\Requests\Timesheets\CreateTimesheetRequest;
use Hourglass\Http\Requests\Timesheets\UpdateTimesheetRequest;
use Hourglass\Models\Job;
use Hourglass\Models\JobShift;
use Hourglass\Models\Report;
use Hourglass\Models\Timesheet;
use Hourglass\Transformers\TimesheetTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TimesheetController extends BaseController
{
    /**
     * ReportController constructor.
     *
     * @param \Hourglass\Transformers\TimesheetTransformer $transformer
     */
    public function __construct(TimesheetTransformer $transformer)
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
    public function index(Request $request): JsonResponse
    {
        $timesheets = $this->resolveAccount($this->account)->timesheets()
            ->with(['employee.agency', 'job', 'shift'])
            ->sort($request->get('sort_by'), $request->get('order'))
            ->paginate($request->get('per_page', 10));

        return $this->respondWithPaginator($timesheets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateTimesheetRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateTimesheetRequest $request): JsonResponse
    {
        $account = $this->resolveAccount($this->account);
        $timesheet = new Timesheet();

        $date = $request->get('date');

        $timesheet->employee_id = $request->get('employee_id');
        $timesheet->job_id = $request->get('job_id');
        $timesheet->time_in = Carbon::parse($date . ' ' . $request->get('time_in'), $account->timezone)->timezone('UTC');
        $timesheet->time_out = Carbon::parse($date . ' ' . $request->get('time_out'), $account->timezone)->timezone('UTC');

        if ($timesheet->time_out->lt($timesheet->time_in)) {
            $timesheet->time_out->addDay();
        }

        $this->determineJobShift($timesheet);

        $this->resolveAccount($this->account)->timesheets()->save($timesheet);

        return $this->respondWithItem($timesheet);
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param UpdateTimesheetRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTimesheetRequest $request, int $id): JsonResponse
    {
        $account = $this->resolveAccount($this->account);
        $timesheet = $account->timesheets()->find($id);

        $date = $request->get('date');

        $timesheet->job_id = $request->get('job_id');
        $timesheet->time_in = Carbon::parse($date . ' ' . $request->get('time_in'), $account->timezone)->timezone('UTC');
        $timesheet->time_out = Carbon::parse($date . ' ' . $request->get('time_out'), $account->timezone)->timezone('UTC');

        if ($timesheet->time_out->lt($timesheet->time_in)) {
            $timesheet->time_out->addDay();
        }

        $this->determineJobShift($timesheet);

        $this->resolveAccount($this->account)->timesheets()->save($timesheet);

        return $this->respondWithItem($timesheet);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return void
     */
    public function destroy(int $id): void
    {
        $timesheet = $this->resolveAccount($this->account)->timesheets()->find($id);

        if (!$timesheet) {
            throw new NotFoundHttpException('Not found.');
        }

        $timesheet->delete();
    }

    private function determineJobShift(Timesheet $timesheet)
    {
        $job = Job::find($timesheet->job_id);
        $shift = $job->shifts()->whereDate('created_at', '=', $timesheet->time_in->toDateString())->first();

        if (!$shift) {
            $shift = new JobShift();
            $shift->account_id = $job->account_id;
            $shift->job_id = $job->id;
            $shift->save();
        }

        $timesheet->job_shift_id = $shift->id;
    }
}
