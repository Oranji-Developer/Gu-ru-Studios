<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
