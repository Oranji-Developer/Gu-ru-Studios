<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileIsFilled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $redirectToRoute = null): Response
    {
        if (!$request->user()->isProfilled()) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Please fill your profile before proceeding.'], 403)
                : redirect()->route($redirectToRoute ?: 'profiled.notice');
        }
        return $next($request);
    }
}
