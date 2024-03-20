<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckVerifier
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->role !== 'verifikator') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
