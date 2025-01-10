<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property int $userCourse_id
 * @property string $desc
 * @property string $rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\UserCourse $userCourse
 * @method static \Database\Factories\TestimoniesFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonies newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonies newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonies onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonies query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonies whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonies whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonies whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonies whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonies whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonies whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonies whereUserCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonies withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Testimonies withoutTrashed()
 * @mixin \Eloquent
 */
class Testimonies extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'testimonies';
    protected $fillable = [
        'userCourse_id',
        'desc',
        'rating',
    ];

    public function userCourse(): BelongsTo
    {
        return $this->belongsTo(UserCourse::class, 'userCourse_id');
    }
}
