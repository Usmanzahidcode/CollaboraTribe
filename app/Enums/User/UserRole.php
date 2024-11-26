<?php

namespace App\Enums\User;

enum UserRole: string
{
    case ADMIN = 'admin';
    case STUDENT = 'student';
}
