<?php

namespace Altenic\MaybeCms\Console\Commands;

use Altenic\MaybeCms\Database\Seeders\MaybeCmsSeeder;
use Altenic\MaybeCms\MaybeCmsServiceProvider;
use Altenic\MaybeCms\Models\Role;
use Altenic\MaybeCms\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class InstallMaybeCmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maybecms:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('migrate:fresh');
        $email = $this->ask('Enter admin user email');
        while (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = $this->ask('Invalid email, try again');
        }
        $password = $this->secret('Enter password');
        while (!preg_match('/\S{8,64}/', $password)) {
            $password = $this->secret('Invalid password, try again');
        }
        $passwordConfirmation = $this->secret('Confirm password');
        while ($passwordConfirmation !== $password) {
            $passwordConfirmation = $this->secret('Password and confirmation don\'t match, try again');
        }
        $user = User::query()->firstOrCreate([
            'email' => $email,
        ], [
            'name' => 'Admin',
            'password' => Hash::make($password),
        ]);
        $user->roles()->attach(Role::query()->firstOrCreate([
            'slug' => 'admin'
        ], [
            'title' => 'Admin'
        ]));
        $this->info('User with provided email and password created');
        $this->call('db:seed', ['--class' => MaybeCmsSeeder::class]);
        $this->call('vendor:publish', ['--provider' => MaybeCmsServiceProvider::class]);
        $this->info('Done');
        return 0;
    }
}
