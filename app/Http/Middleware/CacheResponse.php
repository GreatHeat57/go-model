<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\ResponseCache\Middlewares\CacheResponse as CacheResponseBase;

class CacheResponse extends CacheResponseBase
{
    /**
     * Bypass cache middleware after form submitted or when a defined flashed session data is set.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  int|null  $lifetimeInSeconds
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next, ...$args): Response
    {
        if ($request->session()->hasOldInput()) {
            return $next($request);
        }

        $flashs = ['errors', 'warning', 'notice', 'success', 'message', 'flash_notification'];

        foreach ($flashs as $flash) {
            if ($request->session()->has($flash)) {
                return $next($request);
            }
        }

        return parent::handle($request, $next, ...$args);
    }
}