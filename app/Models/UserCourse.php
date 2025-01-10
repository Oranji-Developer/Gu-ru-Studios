<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * 
 *
 * @property int $id
 * @property int $children_id
 * @property int $course_id
 * @property string $subscription
 * @property string $start_date
 * @property string $end_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Children $children
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\Testimonies|null $testimonies
 * @method static \Database\Factories\UserCourseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereChildrenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereSubscription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCourse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserCourse extends Model
{
    use HasFactory;

    protected $table = 'user_courses';
    protected $fillable = [
        'children_id',
        'course_id',
        'subscription',
        'start_date',
        'end_date',
        'status',
    ];

    public function children(): BelongsTo
    {
        return $this->belongsTo(Children::class, 'children_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function testimonies(): HasOne
    {
        return $this->hasOne(Testimonies::class, 'userCourse_id');
    }
}
