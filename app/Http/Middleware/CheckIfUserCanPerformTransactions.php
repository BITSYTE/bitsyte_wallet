<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class CheckIfUserCanPerformTransactions
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
        /** @var \App\Models\User $user */
        $user = JWTAuth::setRequest($request)->parseToken()->authenticate();

        if (!$user->isConfirmed()) {
            return response()->json(['errors' => ['You must confirm your E-mail to perform this operation']], 401);
        }

        return $next($request);
    }
}
