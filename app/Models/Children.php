<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
