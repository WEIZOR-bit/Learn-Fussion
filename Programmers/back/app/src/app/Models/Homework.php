<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Homework extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task',
        'created_by',
        'updated_by'
    ];

    /**
     * Get the lessons that have this homework.
     *
     * @return HasMany
     */
    public function homework_lessons(): HasMany
    {
        return $this->hasMany(HomeworkLesson::class);
    }

    /**
     * Get history of people finishing this homework.
     *
     * @return HasMany
     */
    public function homeworks_finished(): HasMany
    {
        return $this->hasMany(HomeworkFinished::class);
    }
}
