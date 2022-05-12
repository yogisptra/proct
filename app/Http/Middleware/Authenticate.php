<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // dd(substr($request->path(),0,5));
        // if (! $request->expectsJson()) {
        //     return '/';
        // }
        if(substr($request->path(),0,5) == 'admin'){
            return route('sysadmin.auth');
        }else{
            return route('auth-user.login');
        }
    }
}
