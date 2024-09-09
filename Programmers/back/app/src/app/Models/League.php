<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property int min_mastery_level
 */
class League extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'min_mastery_level'
    ];
}
