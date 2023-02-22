<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ... $permission)
    {
        $request->headers->set('Accept', 'application/json');

        $permissions = is_array($permission)
		? $permission
		: explode('|', $permission);
        
        if (Auth()->check()){
            if (in_array(Auth::user()->role, $permissions)) {
                return $next($request);
            }else{
                $success = api_format(false, ["403" => "403 Forbidden"], [], []);
                return response()->json($success, 403);
            }

        }else{
            $success = api_format(false, ["403" => "403 Forbidden"], [], []);
            return response()->json($success, 403);
        }

    }
}
