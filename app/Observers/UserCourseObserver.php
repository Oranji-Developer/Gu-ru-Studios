<?php

namespace App\Observers;

use App\Enum\Users\StatusEnum;
use App\Models\UserCourse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class UserCourseObserver
{
    /**
     * Handle the UserCourse "retrieved" event.
     *
     * @param UserCourse $userCourse
     * @return void
     */
    public function retrieved(UserCourse $userCourse): void
    {
        if ($userCourse->end_date < Carbon::now()->toDateString() && $userCourse->status !== StatusEnum::COMPLETED->value) {
            Log::info('Retrieved event fired for UserCourse', ['id' => $userCourse->id]);
            $userCourse->status = StatusEnum::COMPLETED->value;
            $userCourse->saveQuietly();
        }
    }
}
