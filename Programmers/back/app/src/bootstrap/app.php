<?php

use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Регистрация маршрутов для API admin
            $adminRouteFiles = glob(base_path('routes/api/admin/*.php'));
            foreach ($adminRouteFiles as $file) {
                Route::middleware('api')
                    ->prefix('api/admin')
                    ->group($file);
            }

            // Регистрация маршрутов для API public
            $publicRouteFiles = glob(base_path('routes/api/public/*.php'));
            foreach ($publicRouteFiles as $file) {
                Route::middleware('api')
                    ->prefix('api/public')
                    ->group($file);
            }
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

//->withMiddleware(function (Middleware $middleware) {
//    $middleware->append(ForceJsonResponse::class);
//})
