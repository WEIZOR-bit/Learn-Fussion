<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task',
        'created_by',
        'updated_by'
    ];

    public function homework_lessons(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Homework_Lesson::class);
    }
}