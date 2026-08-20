<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next)
    {
        // if (!Auth::check()) {
            if (!session()->has('is_authenticated')) {
            //return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
            return redirect()->route('login')->with('error', 'Session expired ,You must be logged in to access this page.');
        }

        return $next($request);
    }
}
