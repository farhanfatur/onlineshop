<?php

namespace App\Http\Middleware;

use Closure;

class BuyerMiddleware
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
        if(auth()->guard('buyer')->user()){
            return $next($request);    
        }else {
            return redirect()->route('indexShop');
        }
        

    }
}
