<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $isAuthorized = $request->session()->get('user');

        if (is_null($isAuthorized)) {
            return redirect()->route('auth.login');
        }

        return $next($request);
    }
}
