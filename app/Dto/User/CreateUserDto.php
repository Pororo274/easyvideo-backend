<?php

namespace App\Dto\User;

use App\Enums\User\UserRoleEnum;

readonly class CreateUserDto
{
    public function __construct(
        public string $email,
        public string $password,
        public string $username,
        public array $roles = [UserRoleEnum::USER]
    ) {
    }
}
