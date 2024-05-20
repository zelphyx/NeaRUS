<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'You must be logged in.'], 401);
        }

        $user = Auth::user();
        if ($user->websiterole !== 'Owner') {
            return response()->json(['error' => 'Access denied. Insufficient permissions.'], 403);
        }

        if (!$user->hasVerifiedEmail()) {
            return response()->json(['error' => 'You must verify your email address.'], 403);
        }

        return $next($request);
    }
}
