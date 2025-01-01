<?php

namespace App\Enum\Contents;

use App\Trait\EnumAction;

enum ContentType:string
{
    use EnumAction;

    case CARYA = 'carya';
}
