<?php

namespace App\Enum\Users;

use App\Trait\EnumAction;

enum RoleEnum: string
{
    use EnumAction;

    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
}
