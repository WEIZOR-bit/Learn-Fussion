<?php

namespace App\Providers;

use App\Models\Challenge;
use App\Models\Course;
use App\Models\CourseFinished;
use App\Models\CourseReview;
use App\Models\Homework;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\User;
use App\Policies\ChallengePolicy;
use App\Policies\CourseFinishedPolicy;
use App\Policies\CoursePolicy;
use App\Policies\CourseReviewPolicy;
use App\Policies\HomeworkPolicy;
use App\Policies\LessonPolicy;
use App\Policies\QuestionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super-Admin') ? true : null;
        });

        Gate::policy(Course::class, CoursePolicy::class);
        Gate::policy(CourseFinished::class, CourseFinishedPolicy::class);
        Gate::policy(CourseReview::class, CourseReviewPolicy::class);
        Gate::policy(Lesson::class, LessonPolicy::class);
        Gate::policy(Challenge::class, ChallengePolicy::class);
        Gate::policy(Homework::class, HomeworkPolicy::class);
        Gate::policy(Question::class, QuestionPolicy::class);
        Gate::policy(User::class, UserPolicy::class);

    }
}
