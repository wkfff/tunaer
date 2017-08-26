<?php

namespace App\Http\Middleware;

use Closure;

class Accessip
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
        
        if( !isset($_SERVER['REMOTE_ADDR']) ) {
            exit("access deny!");
        }
        return $next($request);
    }
}
