<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class Logging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    # Handle: Xử lý chiều đi (request)
    public function handle($request, Closure $next)
    {
        Log::debug($request->method());
        return $next($request);
    }

    # Terminate: Xử lý chiều về (response)
    public function terminate($request, $response)
    {
        Log::debug($response->status());
    }
}
