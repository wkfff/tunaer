<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class logined
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
        if( !Session::get('uid') ) {
            if( strtoupper($_SERVER['REQUEST_METHOD']) == 'GET' ) {
                return redirect('/login');
            }else{
                exit("400-login need");
            }
        }
        return $next($request);
    }
}
