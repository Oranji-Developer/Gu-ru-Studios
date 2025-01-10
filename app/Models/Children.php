<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $class
 * @property string $gender
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserCourse> $userCourse
 * @property-read int|null $user_course_count
 * @method static \Database\Factories\ChildrenFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Children newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Children newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Children query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Children whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Children whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Children whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Children whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Children whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Children whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Children whereUserId($value)
 * @mixin \Eloquent
 */
class Children extends Model
{
    use HasFactory;

    protected $table = 'children';
    protected $fillable = [
        'name',
        'class',
        'gender',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userCourse(): HasMany
    {
        return $this->hasMany(UserCourse::class, 'children_id');
    }
}
