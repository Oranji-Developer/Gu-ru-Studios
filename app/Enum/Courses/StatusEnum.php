<?php

namespace App\Enum\Courses;

use App\Trait\EnumAction;

enum StatusEnum: string
{
    use EnumAction;

    case PAID = 'Lunas';
    case UNPAID = 'Belum Lunas';
    case CANCELED = 'Dibatalkan';
}
