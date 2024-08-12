<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
<<<<<<< HEAD
use Illuminate\Support\Facades\Gate;
=======
>>>>>>> b75655ec499b2dbbe13cb7ef96f6c849490a6d43

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
<<<<<<< HEAD
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
=======
        //
>>>>>>> b75655ec499b2dbbe13cb7ef96f6c849490a6d43
    }
}
