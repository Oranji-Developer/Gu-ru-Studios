<?php

namespace App\Services\Admin;

use App\Models\Course;
use App\Services\Abstracts\CrudAbstract;
use App\Trait\FileHandleTrait;
use App\Trait\UpdateHandleTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseService extends CrudAbstract
{
    use FileHandleTrait, UpdateHandleTrait;

    public function store($request): bool
    {
        try {
            DB::beginTransaction();
            $course = Course::create($request->getCourse());

            $course->schedule()->create($request->getSchedule());

            DB::commit();
            Log::info("Store course data Success");
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error when store course data " . $e->getMessage());
            return false;
        }
    }

    public function update($request, ?int $id = null): bool
    {
        try {
            DB::beginTransaction();
            $course = Course::with('schedule')->findOrFail($id);

            $this->handleUpdate($course, $request->getCourse(), ['thumbnail']);

            if ($course->schedule) {
                $this->handleUpdate($course->schedule, $request->getSchedule());
            }

            DB::commit();
            Log::info("Update course data Success");
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error when update course data " . $e->getMessage());
            return false;
        }
    }
}
