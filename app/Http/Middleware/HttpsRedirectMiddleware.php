<?php

namespace App\Http\Middleware;

use Closure;

class HttpsRedirectMiddleware
{
    public function handle($request, Closure $next)
    {
        if (config('app.ssl') === 'https' && !$request->secure()) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
