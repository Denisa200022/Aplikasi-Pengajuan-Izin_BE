<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and has role 'user'
        if (Auth::check() && Auth::user()->role !== 'user') {
            // If not, return unauthorized response
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // If user is authenticated and has role 'user', proceed to the next middleware
        return $next($request);
    }
}
