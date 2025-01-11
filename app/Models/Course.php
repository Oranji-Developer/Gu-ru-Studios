<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 *
 *
 * @property int $id
 * @property int $mentor_id
 * @property string $title
 * @property string $desc
 * @property int $capacity
 * @property string $cost
 * @property string $disc
 * @property string $course_type
 * @property string|null $class
 * @property string|null $thumbnail
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Mentor $mentor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Schedule> $schedule
 * @property-read int|null $schedule_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserCourse> $userCourse
 * @property-read int|null $user_course_count
 * @method static \Database\Factories\CourseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCourseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereDisc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereMentorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Course whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';
    protected $fillable = [
        'title',
        'desc',
        'capacity',
        'cost',
        'disc',
        'course_type',
        'class',
        'thumbnail',
        'status',
        'mentor_id',
    ];

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(Mentor::class, 'mentor_id')->withTrashed();
    }

    public function schedule(): HasOne
    {
        return $this->hasOne(Schedule::class, 'course_id');
    }

    public function userCourse(): HasMany
    {
        return $this->hasMany(UserCourse::class, 'course_id');
    }
}
