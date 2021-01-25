<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UserRoles;
use Carbon\Carbon;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an admin user';

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
        $first_name = $this->ask('What is the first name?');
        $last_name = $this->ask('What is the last name?');
        $email = $this->ask('What is the email address?');
        $password = $this->secret('What is the password?');

        $admin = new User();
        $admin->email = $email;
        $admin->first_name = $first_name;
        $admin->last_name = $last_name;
        $admin->password = Hash::make($password);
        $admin->email_verified_at = Carbon::now();
        $admin->save();

        UserRoles::create([
            'user_id' => $admin->id,
            'role' => 'admin'
        ]);

        $this->info('Admin with email ' . $email . ' was created');
    }
}
