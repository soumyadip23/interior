<?php

namespace App\Http\Middleware;

use Closure;

class Verified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (empty(auth()->user()->email_verified_at)) {
            return response()->json('Email is not verified');
        }
        return $next($request);
    }
}
