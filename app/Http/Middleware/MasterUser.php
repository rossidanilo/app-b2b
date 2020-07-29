<?php

namespace App\Http\Middleware;

use Closure;

class MasterUser
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
        if (auth()->check() && auth()->user()->admin && auth()->user()->master) {
            
        return $next($request);
        
        } else {

            return redirect('/admin');
        }
    }
}
