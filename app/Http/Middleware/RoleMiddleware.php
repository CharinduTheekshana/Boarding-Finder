<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $allowed = collect($roles)->map(fn ($role) => trim((string) $role))->filter();

        if ($allowed->isNotEmpty() && ! $allowed->contains($request->user()->role?->name)) {
            abort(403);
        }

        return $next($request);
    }
}
