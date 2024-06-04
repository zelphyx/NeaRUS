<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in.'], 401);
        }

        $user = Auth::user();
        if ($user->websiterole !== 'Admin') {
            return response()->json(['error' => 'Access denied. Insufficient permissions.'], 403);
        }

        return $next($request);
    }
}
