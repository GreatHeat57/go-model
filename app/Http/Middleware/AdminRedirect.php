<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminRedirect
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
        //check if logged in user is not admin and if then redirect to admin dashboard
        if(Auth::check() && Auth::User()->user_type_id == config('constant.admin_type_id')){
            $this->redirectTo = url(config('larapen.admin.route_prefix', 'admin'));
            return redirect($this->redirectTo);
        }
        return $next($request);
    }
}
