<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // career office only — students/professors get bounced here
        if (! $request->user() || $request->user()->role !== 'admin') {
            abort(403, 'Admin access required.');
        }

        return $next($request);
    }
}
