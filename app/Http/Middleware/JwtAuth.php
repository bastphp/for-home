<?php

namespace App\Http\Middleware;

use App\Exceptions\AppException;
use Closure;
use App\tools\Jwt;

class JwtAuth
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
        // Pre-Middleware Action
        $token = $request->header('xw-token', '');
        if (!Jwt::checkToken($token)){
            throw new AppException('jwt checked error', 10001);
        }
        $request->merge(['user_id' => Jwt::parserToken($token)]);
        $response = $next($request);

        // Post-Middleware Action

        return $response;
    }
}
