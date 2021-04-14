<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CacheControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $res = $next($request);

        //$res->headers->set('Last-Modified', gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
        //$res->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
        //$res->headers->set('Cache-Control', 'max-age=3600');

        return $res;
    }
}
