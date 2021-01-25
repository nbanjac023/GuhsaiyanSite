<?php

namespace App\Http\Middleware;

use Closure;

class NoAdmin
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
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                // abort(403, 'Unauthorized');
                return redirect('/');
            }
        }
        return $next($request);
    }
}
