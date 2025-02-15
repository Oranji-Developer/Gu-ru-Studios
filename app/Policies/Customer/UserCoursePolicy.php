<?php

namespace App\Policies\Customer;

use App\Models\User;
use App\Models\UserCourse;
use Illuminate\Auth\Access\Response;

class UserCoursePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserCourse $userCourse): bool
    {
        return $user->id === $userCourse->children->user_id;
    }
}
