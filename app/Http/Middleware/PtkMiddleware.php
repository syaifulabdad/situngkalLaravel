<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PtkMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (in_array(Auth::user()->user_type, ['ptk', '3'])) {
                return $next($request);
            } else {
                abort(403);
            }
        } else {
            return redirect('/login')->with('message', 'Login to access the Panel');
        }

        return $next($request);
    }
}
