<?php

namespace Hourglass\Console\Commands;

use Carbon\Carbon;
use DB;
use Hourglass\Models\Account;
use Hourglass\Models\Agency;
use Hourglass\Models\Employee;
use Hourglass\Models\Job;
use Hourglass\Models\JobShift;
use Illuminate\Console\Command;
use League\Csv\Reader as CsvReader;

class MigrateReportrData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportr:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from Reportr';

    /**
     * @var \Hourglass\Models\Account
     */
    protected $account;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->account = Account::find(1);

        if (!$this->account) {
            throw new \Exception('No account found.');
        }

        $employeeIdMap = $this->migrateEmployees();
        $this->info('Migrated ' . count($employeeIdMap) . ' employees.');

        $jobIdMap = $this->migrateJobs();
        $this->info('Migrated ' . count($jobIdMap) . ' jobs.');

        $shiftIdMap = $this->migrateShifts($jobIdMap);
        $this->info('Migrated ' . count($shiftIdMap) . ' shifts.');

        $count = $this->migrateTimesheets($employeeIdMap, $jobIdMap, $shiftIdMap);
        $this->info('Migrated ' . $count . ' timesheets.');
    }

    private function migrateEmployees()
    {
        $reader = CsvReader::createFromPath(storage_path('reportr/employees.csv'));

        $employeeIdMap = [];
        foreach ($reader->setOffset(1)->fetch() as $index => $row) {
            list($id, $card, $firstName, $lastName) = $row;
            if ($id == '0') {
                continue;
            }
            list($name, $agencyName) = $this->prepareEmployeeNameAndAgency($firstName, $lastName);
            $agency = $agencyName !== null ? $this->account->agencies()->where('name', $agencyName)->first() : null;
            if (!$agency && $agencyName !== null) {
                $agency = new Agency(['name' => $agencyName]);
                $this->account->agencies()->save($agency);
            }
            $employee = new Employee();
            $employee->name = $name;
            $employee->terminal_key = ($card === '[DEL]' || strlen($card) > 6) ? null : trim($card);
            $employee->location_id = 1;
            if ($agency) $employee->agency_id = $agency->id;

            $this->account->employees()->save($employee);

            $employeeIdMap[(int)$id] = $employee->id;
        }

        return $employeeIdMap;
    }

    private function migrateJobs()
    {
        $reader = CsvReader::createFromPath(storage_path('reportr/jobs.csv'));

        $jobIdMap = [];
        foreach ($reader->setOffset(1)->fetch() as $index => $row) {
            list($id, $number, $name, $customer, $location, $quantity, $employees) = $row;

            $job = new Job();
            $job->number = trim($number);

            $name = $this->removeExcessWhitespace(trim($name));
            $name = ucwords(strtolower($name));

            $job->name = $name;
            $job->location_id = $this->getLocation($location);
            $job->customer = strtoupper(trim($customer));

            $job->productivity = [
                'type' => 'quantity',
                'quantity' => (int)$quantity,
                'employees' => (int)$employees,
            ];

            $this->account->jobs()->save($job);
            $jobIdMap[(int)$id] = $job->id;
        }

        return $jobIdMap;
    }

    private function migrateShifts($jobIdMap)
    {
        $reader = CsvReader::createFromPath(storage_path('reportr/jobLog.csv'));

        $shiftIdMap = [];
        foreach ($reader->setOffset(1)->fetch() as $index => $row) {
            list($id, $jobId, $date, $quantity, /* hrs */, $setupTime, /* score */, $comments) = $row;

            if (!isset($jobIdMap[$jobId]) || empty($quantity)) continue;

            $shift = new JobShift();
            $shift->job_id = $jobIdMap[$jobId];
            $shift->comments = $this->removeExcessWhitespace(trim($comments));
            $shift->created_at = Carbon::parse($date, 'America/Los_Angeles')->setTime(8, 0)->timezone('UTC');
            $shift->updated_at = $shift->created_at;
            $shift->productivity = [
                'quantity' => (int)$quantity,
                'setup' => (float)$setupTime
            ];
            $shift->closed = true;

            $this->account->shifts()->save($shift);
            $shiftIdMap[(int)$id] = $shift->id;
        }

        return $shiftIdMap;
    }

    private function migrateTimesheets($employeeIdMap, $jobIdMap, $shiftIdMap)
    {
        $reader = CsvReader::createFromPath(storage_path('reportr/clockLog.csv'));

        $timesheets = [];
        foreach ($reader->setOffset(1)->fetch() as $index => $row) {
            list(/* id */, $employeeId, $jobId, $date, $timeIn, $timeOut, /* hrs */, /* week */, $shiftId) = $row;

            if (!isset($jobIdMap[$jobId], $employeeIdMap[$employeeId], $shiftIdMap[$shiftId]) || $employeeId == '0') {
                continue;
            }

            $timeIn = Carbon::parse($date . ' ' . $timeIn, 'America/Los_Angeles')->timezone('UTC');
            $timeOut = Carbon::parse($date . ' ' . $timeOut, 'America/Los_Angeles')->timezone('UTC');
            if ($timeIn->gt($timeOut)) {
                $timeOut->addDay();
            }

            $timesheet = [
                'account_id' => $this->account->id,
                'employee_id' => $employeeIdMap[$employeeId],
                'job_id' => $jobIdMap[$jobId],
                'job_shift_id' => $shiftIdMap[$shiftId],
                'time_in' => $timeIn->toDateTimeString(),
                'time_out' => $timeOut->toDateTimeString(),
                'created_at' => $timeIn->toDateTimeString(),
                'updated_at' => $timeOut->toDateTimeString(),
            ];
            $timesheets[] = $timesheet;
        }

        foreach (array_chunk($timesheets, 5000) as $chunk) {
            DB::table('timesheets')->insert($chunk);
        }

        return count($timesheets);
    }

    private function prepareEmployeeNameAndAgency($firstName, $lastName)
    {
        $name = $firstName . ' ' . $lastName;

        // Remove excess whitespace.
        $name = $this->removeExcessWhitespace($name);;

        // Capital Case
        $name = ucwords(strtolower($name));

        // Replace acronyms.
        $replacements = [
            'Vforce' => 'VForce',
            'Vf' => 'VForce',
            'V Force' => 'VForce',
            'V F' => 'VForce',
            'Ilink' => 'iLink',
            'I L' => 'iLink',
            'Il' => 'iLink',
            'Ilin' => 'iLink',
            'Teamwork' => 'Teamwork Packaging',
            'Twp' => 'Teamwork Packaging',
            '1stchoice' => '1st Choice',
            '1st Choice' => '1st Choice',
            'First Choice' => '1st Choice',
        ];
        $name = str_replace(array_keys($replacements), array_values($replacements), $name);

        $agencyName = null;
        if (strpos($name, 'VForce') !== false) {
            $agencyName = 'VForce';
        } elseif (strpos($name, 'iLink') !== false) {
            $agencyName = 'iLink';
        } elseif (strpos($name, 'Teamwork Packaging') !== false) {
            $agencyName = 'Teamwork Packaging';
        } elseif (strpos($name, '1st Choice') !== false) {
            $agencyName = '1st Choice';
        } elseif (strpos($name, 'Staff Depot') !== false) {
            $agencyName = 'Staff Depot';
        }

        if ($agencyName !== null) {
            $name = str_replace($agencyName, '', $name);
            $name = $this->removeExcessWhitespace($name);
        }
        return [$name, $agencyName];
    }

    private function removeExcessWhitespace($string)
    {
        return preg_replace('/(\s)+/', ' ', $string);
    }

    private function getLocation($location)
    {
        $location = strtolower($location);

        switch ($location) {
            case '494': return 1;
            case '495': return 2;
            case 'cooley': return 3;
            default: return 1;
        }
    }
}
