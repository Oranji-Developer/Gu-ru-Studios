<?php

namespace App\Enum\Courses;

use App\Trait\EnumAction;

enum StatusEnum: string
{
    use EnumAction;

    case ACTIVE = 'Aktif';
    case INACTIVE = 'Tidak Aktif';
}
