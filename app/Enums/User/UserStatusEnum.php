<?php

namespace App\Enums\User;

enum UserStatusEnum: string
{
    case Active = 'active';
    case Banned = 'banned';
}
