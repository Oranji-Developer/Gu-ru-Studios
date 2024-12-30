<?php

namespace App\Enum\Courses;

use App\Trait\EnumAction;

enum CourseType: string
{
    use EnumAction;

    case ACADEMIC = 'akademik';
    case ABK = 'abk';
    case ARTS = 'seni';
}
