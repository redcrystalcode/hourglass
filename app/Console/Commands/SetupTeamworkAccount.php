<?php

namespace Hourglass\Console\Commands;

use Hourglass\Models\Account;
use Hourglass\Models\Location;
use Hourglass\Models\User;
use Illuminate\Console\Command;

class SetupTeamworkAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up the basic Teamwork Packaging account.';

    /**
     * Create a new command instance.
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
        \DB::beginTransaction();
        try {
            $account = Account::firstOrCreate([
                'name' => 'Teamwork Packaging'
            ]);

            $user = new User([
                'name' => 'Zainab Mehdi',
                'username' => 'zainabm',
                'email' => 'zainab@twpackaging.com',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]);
            $account->users()->save($user);

            $user = new User([
                'name' => 'Teamwork Packaging',
                'username' => 'twpackaging',
                'email' => 'zainab+terminal@twpackaging.com',
                'password' => bcrypt('pack123'),
                'role' => 'terminal'
            ]);
            $account->users()->save($user);

            $locations = [
                new Location(['name' => 'San Bernardino - 494']),
                new Location(['name' => 'San Bernardino - 495']),
                new Location(['name' => 'Cooley']),
            ];
            $account->locations()->saveMany($locations);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        $this->info('Account created successfully!');
    }
}
