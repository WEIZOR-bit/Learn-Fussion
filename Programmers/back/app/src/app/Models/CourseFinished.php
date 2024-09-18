<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseFinished extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'finished_at'
    ];
    protected $table = 'courses_finished';


    /**
     * Get the user who finished the course.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * Get the course that was finished.
     *
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class,'course_id');
    }
}
