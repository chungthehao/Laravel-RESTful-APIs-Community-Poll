<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BasicAuth
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
        // Laravel default check (username, password trong header của basic auth) match
        // với (users.email, users.password) trong bảng users
        return  Auth::onceBasic() ?: $next($request);
        # Vđ 1: Muốn ủy quyền cho API nào đó chẳng lẽ đưa thông tin username/password cho nó.
        # Vđ 2: Nếu ko dùng encrypt thì sẽ lộ thông tin trong header của request.
    }
}
