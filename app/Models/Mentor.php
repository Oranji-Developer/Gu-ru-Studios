<?php

namespace App\Models;

use App\Enum\Courses\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
