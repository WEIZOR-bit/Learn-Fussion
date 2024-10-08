<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeworkUnchecked extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'submission_link',
        'homework_id',
        'user_id',
    ];
    protected $table = 'homeworks_unchecked';


    /**
     * Get the homework to be checked.
     *
     * @return BelongsTo
     */
    public function homework(): BelongsTo
    {
        return $this->belongsTo(Challenge::class, 'homework_id');
    }

    /**
     * Get the user who sent the homework.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
