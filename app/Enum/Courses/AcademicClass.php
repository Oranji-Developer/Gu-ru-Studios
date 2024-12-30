<?php

namespace App\Enum\Courses;

use App\Trait\EnumAction;

enum AcademicClass: string
{
    use EnumAction;

    case CLASS1 = 'Kelas 1';
    case CLASS2 = 'Kelas 2';
    case CLASS3 = 'Kelas 3';
    case CLASS4 = 'Kelas 4';
    case CLASS5 = 'Kelas 5';
    case CLASS6 = 'Kelas 6';
}
