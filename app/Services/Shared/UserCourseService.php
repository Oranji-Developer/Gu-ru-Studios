<?php

namespace App\Services\Shared;

use App\Models\UserCourse;
use App\Services\Abstracts\CrudAbstract;
use Exception;
use Illuminate\Support\Facades\Log;

class UserCourseService extends CrudAbstract
{
    public function store($request): bool
    {
        try {
            UserCourse::create($request->getData());

            Log::info("store user course success");
            return true;
        } catch (Exception $e) {
            Log::error("error when store user course: " . $e->getMessage());
            return false;
        }
    }

    public function update($request, ?int $id = null): bool
    {
        try {
            UserCourse::find($id)->update($request->getData());

            Log::info("update user course success");
            return true;
        } catch (Exception $e) {
            Log::error("error when update user course: " . $e->getMessage());
            return false;
        }
    }
}
