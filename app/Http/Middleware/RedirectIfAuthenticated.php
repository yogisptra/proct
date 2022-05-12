<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $guards = empty($guards) ? [null] : $guards;

        if (Auth::guard($guard)->check()) {
            switch ($guard) {
                case 'web':
                    $redirect_route = 'home';
                    break;
                default:
                    $redirect_route = 'dashboard-users';
                    break;
            }

            return redirect(route($redirect_route));
        }

        return $next($request);
    }
}
