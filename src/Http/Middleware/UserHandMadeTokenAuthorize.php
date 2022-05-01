<?php

namespace Geeksesi\TodoLover\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserHandMadeTokenAuthorize
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
        if ($authorize = $request->header("authorization", false)) {
            $token = substr($authorize, 7);
            $owner = \OwnerModel::where("token", $token)->first();
            Auth::setUser($owner);
        }
        return $next($request);
    }
}
