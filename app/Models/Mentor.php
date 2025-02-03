<?php

namespace App\Models;

use App\Enum\Courses\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property string $gender
 * @property string $desc
 * @property string|null $profile_picture
 * @property string|null $cv
 * @property string|null $portfolio
 * @property string $field
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Course> $course
 * @property-read int|null $course_count
 * @method static \Database\Factories\MentorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor whereCv($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor wherePortfolio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor whereProfilePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mentor withoutTrashed()
 * @mixin \Eloquent
 */
class Mentor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mentors';
    protected $fillable = [
        'name',
        'address',
        'desc',
        'profile_picture',
        'cv',
        'phone',
        'portfolio',
        'field',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function ($mentor) {
            $mentor->course()->update(['status' => StatusEnum::INACTIVE->value]);
        });
    }

    public function course(): HasMany
    {
        return $this->hasMany(Course::class, 'mentor_id');
    }
}
