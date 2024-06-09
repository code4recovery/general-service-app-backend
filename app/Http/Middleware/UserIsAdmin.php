<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user()->first();

        if (!$user) {
            return redirect('login')->with('error', 'You must be logged in to access this page.');
        }

        if (!$user->admin) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
