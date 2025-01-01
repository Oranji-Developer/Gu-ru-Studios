<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mentor extends Model
{
    use HasFactory;

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

    public function course(): HasMany
    {
        return $this->hasMany(Course::class, 'mentor_id');
    }
}
