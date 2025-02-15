<?php

namespace App\Policies\Customer;

use App\Models\Testimonies;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TestimonyPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Testimonies $testimonies): bool
    {
        return $user->id === $testimonies->userCourse->children->user_id;
    }
}
