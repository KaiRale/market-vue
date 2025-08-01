<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // стандартная аутетификация для админа
        if (auth()->user()->is_admin) {
            return $next($request);
        }
        return response([
            'message' => 'forbidden'
        ], \Illuminate\Http\Response::HTTP_FORBIDDEN);
    }
}
