<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
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
        

        if(auth::user()->usertype == "client")
        {
           return $next($request);
        }
        else
        {
            return redirect('/home')->with('status', "Acces interdit");
        } 
        
    }
}
