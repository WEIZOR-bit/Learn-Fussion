<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'average_rating',
        'description',
        'review_count',
        'created_by',
        'updated_by'
    ];

    protected $table = 'courses';

    /**
     * Get all lessons in this course.
     *
     * @return HasMany
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * Get all reviews for this course.
     *
     * @return HasMany
     */
    public function course_reviews(): HasMany
    {
        return $this->hasMany(CourseReview::class);
    }

    /**
     * Get history of people finishing the course.
     *
     * @return HasMany
     */
    public function courses_finished(): HasMany
    {
        return $this->hasMany(CourseFinished::class);
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
