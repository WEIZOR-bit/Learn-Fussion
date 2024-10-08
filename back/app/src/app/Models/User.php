<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use \Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
/**
 * @property int mastery_level
 * @property int hearts
 * @property string|null $last_active_at
 * @property string|null $started_streak_at
 */
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard_name = 'user';
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'mastery_level',
        'hearts',
        'mastery_tag',
        'started_streak_at',
        'last_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the subscriptions of this user.
     *
     * @return HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the lessons finished by this user.
     *
     * @return HasMany
     */
    public function lessons_finished(): HasMany
    {
        return $this->hasMany(LessonFinished::class);
    }

    /**
     * Get the homeworks finished by this user.
     *
     * @return HasMany
     */
    public function homeworks_finished(): HasMany
    {
        return $this->hasMany(HomeworkFinished::class);
    }

    /**
     * Get the reviews to courses written by this user.
     *
     * @return HasMany
     */
    public function course_reviews(): HasMany
    {
        return $this->hasMany(CourseReview::class);
    }

    /**
     * Get the courses finished by this user.
     *
     * @return HasMany
     */
    public function courses_finished(): HasMany
    {
        return $this->hasMany(CourseFinished::class);
    }

    /**
     * Get the friends of this user.
     *
     * @return HasMany
     */
    public function friends(): HasMany
    {
        return $this->hasMany(Friend::class);
    }
}
