<?php

namespace App\Http\Middleware;

use App\Helper;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $url = 'error';
                if (Helper::isAdmin()) {
                    $url = '/admin';
                } elseif (Helper::isCompany() || Helper::isManager()) {
                    $url = '/';
                }
                return redirect($url);
            }
        }

        return $next($request);
    }
}
