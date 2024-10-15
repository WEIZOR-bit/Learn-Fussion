<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'correct'
    ];

    protected $table = 'answers';

    /**
     * Get the answer association.
     *
     * @return HasMany
     */
    public function answer(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class, 'question_answers');
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_answers');
    }
}
