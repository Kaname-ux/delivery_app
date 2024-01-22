<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LivreurMiddleware
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
        if(auth::user()->usertype == "livreur")
        {
           return $next($request);
        }
        else
        {
            return redirect('/home')->with('status', "Acces interdit");
        }

        
    }
}
