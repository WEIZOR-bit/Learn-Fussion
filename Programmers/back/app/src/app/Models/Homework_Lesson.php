<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homework_Lesson extends Model
{
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
