<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order',
        'name',
        'description',
        'tutorial_link',
        'average_rating',
        'review_count',
        'question_count',
        'created_by',
        'updated_by',
        'course_id',
    ];

    /**
     * Get the course this lesson is in.
     *
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Get the questions in this lesson
     *
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get history of people finishing the lesson.
     *
     * @return HasMany
     */
    public function lessons_finished(): HasMany
    {
        return $this->hasMany(LessonFinished::class);
    }

    /**
     * Get the links to homeworks in this lesson.
     *
     * @return HasMany
     */
    public function homework_lessons(): HasMany
    {
        return $this->hasMany(HomeworkLesson::class);
    }
}
