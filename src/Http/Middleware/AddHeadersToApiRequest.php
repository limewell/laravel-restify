<?php

namespace Limewell\LaravelRestify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddHeadersToApiRequest
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (config('laravel-restify.json_response') === true) {
            $request->headers->set('Accept', 'application/json');
        }

        return $next($request);
    }
}
