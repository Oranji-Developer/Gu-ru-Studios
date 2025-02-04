<?php

namespace App\Observers;

use App\Enum\Users\StatusEnum;
use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Support\Facades\Log;

class UserCourseObserver
{
    /**
     * Handle the UserCourse "updated" event.
     */
    public function updated(UserCourse $userCourse): void
    {
        try {
            if ($userCourse->isDirty('status')) {
                $course = Course::findOrFail($userCourse->course_id);

                if ($userCourse->status === StatusEnum::PAID->value) {
                    $course->increment('enrolled');
                } else if ($userCourse->status === StatusEnum::COMPLETED->value) {
                    $course->decrement('enrolled');
                }
            }

            Log::info("Update Enrolled Course Success");
        } catch (\Exception $e) {
            Log::error("Error when update user xp " . $e->getMessage());
        }
    }
}
