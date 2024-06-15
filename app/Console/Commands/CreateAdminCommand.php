<?php

namespace App\Console\Commands;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Dto\User\CreateUserDto;
use App\Enums\User\UserRoleEnum;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-admin {--email=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user with admin role';

    /**
     * Execute the console command.
     */
    public function handle(UserRepositoryContract $userRepo)
    {
        $username = 'admin-' . Str::random(10);
        $password = $this->option('password') ?? Str::random(10);
        $email = $this->option('email') ?? (Str::random() . '@easyvideo.com');

        $userRepo->store(new CreateUserDto(
            email: $email,
            password: $password,
            username: $username,
            roles: [UserRoleEnum::USER, UserRoleEnum::ADMIN]
        ));

        $this->info('Successfully generated new admin with credentials:');
        $this->info('Email: ' . $email);
        $this->info('Password: ' . $password);
    }
}
