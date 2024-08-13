<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeworkFinished extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'homework_id',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function homework(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Homework::class);
    }
}
