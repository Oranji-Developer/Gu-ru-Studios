<?php

namespace App\Enum\Users;

use App\Trait\EnumAction;

enum RatingEnum: string
{
    use EnumAction;

    case ONE = '1';
    case TWO = '2';
    case THREE = '3';
    case FOUR = '4';
    case FIVE = '5';
}
