<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Пропускаем запрос дальше в приложение
        $response = $next($request);

        // Принудительно устанавливаем заголовок Content-Type в application/json
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
