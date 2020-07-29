<?php

namespace App\Http\Middleware;

use Closure;

class ActiveUser
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

        if (auth()->user()->active == 0) {
            $user = auth()->user();
            auth()->logout();
            return redirect()->route('login')
                ->withError('Your account was blocked at');
        }

        return $next($request);
    }
}
