<?php

namespace App\Http\Middleware;

use Closure;
use App;

class RestrictWebAccess
{
    public function handle($request, Closure $next)
    {
        // Se você entrar por meio de um nome de domínio da API, será negado o acesso.
        // Isso é feito para evitar dupla entrada no site, confundindo usuários e otimização de SEO.
        if (App::environment('production') && is_request_from_api()) {
            return response('Bad Request.', 400);
        }

        return $next($request);
    }
}
