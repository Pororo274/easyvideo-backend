<?php

namespace App\Dto\User;

use Illuminate\Support\Carbon;

readonly class UserDto
{
    public function __construct(
        public int $id,
        public string $email,
        public string $username,
        public bool $subscription,
        public Carbon $createdAt
    ) {}
}
