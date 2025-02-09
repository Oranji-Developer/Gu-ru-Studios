<?php

namespace App\Observers;

use App\Enum\Courses\CourseType;
use App\Enum\Courses\StatusEnum;
use App\Models\Course;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     */
    public function created(Event $event): void
    {
        try {
            DB::transaction(function () use ($event) {
                $query = Course::query();

                if ($event->course_type !== CourseType::ABK->value) {
                    $query->where('class', $event->class);

                } else {
                    $query->where('course_type', CourseType::ABK->value);
                }

                $affected = $query->update(['disc' => $event->disc]);

                Log::info('Courses updated via Observer', [
                    'event_id' => $event->id,
                    'affected_rows' => $affected,
                    'course_type' => $event->course_type
                ]);
            });
        } catch (\Exception $e) {
            Log::error("Error at Event Created: {$e->getMessage()}");
        }
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event): void
    {
        try {
            DB::transaction(function () use ($event) {
                if ($event->wasChanged('status') && $event->status == StatusEnum::INACTIVE->value) {
                    $query = Course::query();

                    if ($event->course_type !== CourseType::ABK->value) {
                        $query->where('class', $event->class);
                    } else {
                        $query->where('course_type', CourseType::ABK->value);
                    }

                    $affected = $query->update(['disc' => 0]);

                    Log::info('Courses disc reset to 0 due to inactive event', [
                        'event_id' => $event->id,
                        'affected_rows' => $affected,
                        'course_type' => $event->course_type
                    ]);
                } elseif ($event->wasChanged(['disc', 'class']) && $event->status == StatusEnum::ACTIVE->value) {
                    $query = Course::query();

                    if ($event->course_type !== CourseType::ABK->value) {
                        $query->where('class', $event->class);
                    } else {
                        $query->where('course_type', CourseType::ABK->value);
                    }

                    $affected = $query->update(['disc' => $event->disc]);

                    Log::info('Courses updated via Observer on Event update', [
                        'event_id' => $event->id,
                        'affected_rows' => $affected,
                        'course_type' => $event->course_type,
                        'changed_fields' => $event->getDirty()
                    ]);
                }
            });
        } catch (\Exception $e) {
            Log::error("Error at Event Updated: {$e->getMessage()}", [
                'event_id' => $event->id,
                'changed_fields' => $event->getDirty()
            ]);
        }
    }
}
