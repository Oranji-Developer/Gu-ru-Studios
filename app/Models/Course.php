<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->belongsTo(Mentor::class, 'mentor_id');
    }

    public function schedule(): HasMany
    {
        return $this->hasMany(Schedule::class, 'course_id');
    }

    public function userCourse(): HasMany
    {
        return $this->hasMany(UserCourse::class, 'course_id');
    }
}
