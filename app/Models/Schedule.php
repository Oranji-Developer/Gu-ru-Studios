<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property int $id
 * @property int $course_id
 * @property string $start_date
 * @property string $end_date
 * @property string $day
 * @property string $start_time
 * @property string $end_time
 * @property int $total_meet
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Course $course
 * @method static \Database\Factories\ScheduleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereTotalMeet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Schedule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';
    protected $fillable = [
        'course_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'day',
        'total_meet'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
