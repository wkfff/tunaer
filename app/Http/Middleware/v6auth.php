<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class v6auth
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
//         检查　adminflag
        if( !Session::get('adminflag') ) {
            if( strtoupper($_SERVER['REQUEST_METHOD']) == 'GET' ) {
                return redirect("/admin/login");
            }else{
                exit("nologin");
            }
        }
        return $next($request);
    }
}
