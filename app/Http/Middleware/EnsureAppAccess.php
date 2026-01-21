<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAppAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !in_array('masterdata-kpi', $user->allowed_apps ?? [])) {
            abort(403, 'Unauthorized. You do not have access to Master Data Hub.');
        }

        return $next($request);
    }
}
