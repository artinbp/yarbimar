<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{

    public function handle($request, Closure $next, ...$roles)
    {
        foreach($roles as $role){
            if ($request->user()->hasRole($role)){
                return $next($request);
            }
        }

        return response()->json(['message' =>'Unauthorized.'], Response::HTTP_UNAUTHORIZED);
    }
}