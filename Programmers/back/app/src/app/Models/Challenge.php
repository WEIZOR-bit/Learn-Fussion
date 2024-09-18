<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Challenge extends Model
{
    use HasFactory;

    protected $table = 'challenges';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'reward',
        'created_by',
        'updated_by'
    ];

    /**
     * Get all completed challenges.
     *
     * @return HasMany
     */
    public function challenges_completed(): HasMany
    {
        return $this->hasMany(ChallengeCompleted::class);
    }

    /**
     * Get all lessons in this course.
     *
     * @return HasMany
     */
    public function challenges_unchecked(): HasMany
    {
        return $this->hasMany(ChallengeUnchecked::class);
    }
}
