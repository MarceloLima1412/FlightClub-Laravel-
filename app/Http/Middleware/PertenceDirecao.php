<?php

namespace App\Http\Middleware;

use Closure;

class PertenceDirecao
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
        if ($request->user() && $request->user()->direcao == 1){
            return $next($request);
        }else{
            throw new AccessDeniedHttpException('Unauthorized!');
        }
    }
}