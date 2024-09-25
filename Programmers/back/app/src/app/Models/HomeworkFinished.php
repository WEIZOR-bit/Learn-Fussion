<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeworkFinished extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'homework_id',
    ];

    protected $table = 'homeworks_finished';

    /**
     * Get the user who finished the homework.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * Get the homework that was finished.
     *
     * @return BelongsTo
     */
    public function homework(): BelongsTo
    {
        return $this->belongsTo(Homework::class,'homework_id');
    }
}
