<?php

namespace App\Enum\User;

use App\Trait\EnumAction;

enum RoleEnum: string
{
    use EnumAction;

    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
    case MENTOR = 'mentor';
}
