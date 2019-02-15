<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;
use Closure;

class CheckLogin
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
        if(!Session::has('admininfo.admin_id')){
            return redirect('admin/login');
        }
        return $next($request);
    }
}
