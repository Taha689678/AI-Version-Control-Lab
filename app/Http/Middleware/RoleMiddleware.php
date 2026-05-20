<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * * We use ...$roles (variadic parameter) so we can pass multiple 
     * roles like 'role:admin,teacher' in the routes file.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Check if user is logged in
            if (!Auth::check()) {
                return redirect()->route('login');
            }

        $user = Auth::user();

        // 2. Check if the user's role is in the allowed list
        // This allows logic like: Route::middleware('role:admin,teacher')
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 3. If not authorized, throw a 403 Forbidden error
        abort(403, 'You do not have permission to access this page.');
    }
}