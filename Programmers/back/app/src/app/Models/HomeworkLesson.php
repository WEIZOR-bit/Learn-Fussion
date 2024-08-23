<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeworkLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'homework_id',
        'lesson_id',
    ];

    /**
     * Get the homework association.
     *
     * @return BelongsTo
     */
    public function homework(): BelongsTo
    {
        return $this->belongsTo(Homework::class, 'homework_id');
    }

    /**
     * Get the lesson association.
     *
     * @return BelongsTo
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }
}
