<?php

namespace App\Enum\Course;

use App\Trait\EnumAction;

enum ArtsClass: string
{
    use EnumAction;

    case DANCE = 'Tari';
    case DRAWING = 'Menggambar';
    case MUSIC = 'Musik';
    case PAINTING = 'Melukis';
    case THEATER = 'Teater';
    case VOCAL = 'Vokal';
}
