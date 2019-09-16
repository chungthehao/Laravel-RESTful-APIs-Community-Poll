<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class TokenAuth
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
        $token = $request->header('X-API-TOKEN');

        // 'test-token-value' lấy trong bảng ở db hay sao đó
        // Cách authenticate này demo thôi, dễ gì cướp token rồi giả danh (header ko đc có encrypt)
        if ('test-token-value' !== $token) {
            abort(Response::HTTP_UNAUTHORIZED, 'Auth token not found.');
        }

        return $next($request);
    }
}
