<?php

namespace App\Dto\User;

readonly class CreateUserDto
{
    public function __construct(
        public string $email,
        public string $password,
        public string $username
    ) {}
}
