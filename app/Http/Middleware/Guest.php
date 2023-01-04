<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class Guest
{

    public function handle($request, Closure $next, $role)
    {
        if (! $request->user()->hasRole($role)) {
            response()->json('Unauthenticated.', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}