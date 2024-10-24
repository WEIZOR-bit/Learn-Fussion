<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
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
        'matter',
        'lesson_id',
    ];

    protected $table = 'questions';

    /**
     * Get the lesson this question is in.
     *
     * @return BelongsTo
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    /**
     * Define the many-to-many relationship with Answer.
     *
     * @return BelongsToMany
     */
    public function answers(): BelongsToMany
    {
        return $this->belongsToMany(Answer::class, 'questions_answers', 'question_id', 'answer_id');
    }
}
