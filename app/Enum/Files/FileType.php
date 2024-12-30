<?php

namespace App\Enum\Files;

use App\Trait\EnumAction;

enum FileType: string
{
    use EnumAction;

    case THUMBNAIL = 'thumbnail';
}
