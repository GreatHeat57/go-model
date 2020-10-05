<?php

namespace App\Http\Middleware;

use Closure;

class CookiesWarning
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
        $response = $next($request);
        try{
            $response->headers->set('Set-Cookie', 'HttpOnly;Secure;SameSite=Strict');
        }catch(\Exception $e){
        }
        return $response;
    }
}
