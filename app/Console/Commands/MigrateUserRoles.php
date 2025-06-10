<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class MigrateUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:user-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate role_id from users to user_has_roles pivot table';

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
     * @return int
     */
    public function handle()
    {
        $users = User::whereNotNull('role_id')->get();
        
        foreach ($users as $user) {
            $user->roles()->attach($user->role_id);
        }

        $this->info('Successfully migrated user roles to pivot table!');
    }
}
