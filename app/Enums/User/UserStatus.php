<?php

namespace App\Enums\User;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case BANNED = 'banned';
}
