<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeworkLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'homework_id',
        'lesson_id',
    ];

    public function homework(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Homework::class);
    }

    public function lesson(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
