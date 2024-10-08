<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumPost extends Model
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content',
        'is_premium',
        'user_id',
    ];
    protected $table = 'forum_posts';

    /**
     * Get the comments to this post.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(ForumComment::class);
    }

    /**
     * Get the likes for this post.
     *
     * @return HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(ForumLike::class);
    }
}
