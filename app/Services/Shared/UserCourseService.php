<?php

namespace App\Services\Shared;

use App\Enum\Users\RoleEnum;
use App\Models\UserCourse;
use App\Notifications\UserCourseStatusUpdatedNotification;
use App\Services\Abstracts\CrudAbstract;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserCourseService extends CrudAbstract
{
    public function store($request): mixed
    {
        try {
            $userCourse = UserCourse::create($request->getData());

            Log::info("store user course success");
            return $userCourse->id;
        } catch (Exception $e) {
            Log::error("error when store user course: " . $e->getMessage());
            return null;
        }
    }

    public function update($request, ?int $id = null): bool
    {
        try {
            $userCourse = UserCourse::findOrFail($id);
            $oldStatus = $userCourse->status;

            $userCourse->update($request->getData());

            if ($oldStatus !== $userCourse->status && Auth::user()->role === RoleEnum::ADMIN->value) {
                $userCourse->load(['course:id,title', 'children.user']);

                $userCourse->children->user->notify(new UserCourseStatusUpdatedNotification($userCourse));
            }

            Log::info("update user course success");
            return true;
        } catch (Exception $e) {
            Log::error("error when update user course: " . $e->getMessage());
            return false;
        }
    }
}
