<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
