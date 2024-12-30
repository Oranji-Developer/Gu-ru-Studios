<?php

namespace App\Enum\User;

use App\Trait\EnumAction;

enum GenderEnum: string
{
    use EnumAction;

    case MA = 'Laki-laki';
    case FE = 'Perempuan';
}
