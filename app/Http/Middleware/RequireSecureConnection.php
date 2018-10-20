<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Request;

class RequireSecureConnection
{
    public function handle($request, Closure $next)
    {
        if (App::environment('production') && !Request::server('HTTP_X_FORWARDED_PROTO') == 'https') {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
