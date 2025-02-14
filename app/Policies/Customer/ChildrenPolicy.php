<?php

namespace App\Policies\Customer;

use App\Models\Children;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ChildrenPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Children $children): bool
    {
        return $user->id === $children->user_id;;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Children $children): bool
    {
        return $user->id === $children->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Children $children): bool
    {
        return $user->id === $children->user_id;
    }
}
