<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            
            // If the user was trying to access a backend admin URL...
            if (Str::startsWith($request->path(), 'backend')) {
                // ...and it's a staff/admin area URL...
                if (Str::contains($request->path(), ['/store/', '/category', '/product', '/modifier', '/logs'])) {
                    return route('backend.admin.login.form');
                }
                // ...otherwise, send them to the owner login.
                return route('backend.login.form');
            }
            
            // For any other case, you can define other redirects or a default
            return route('frontend.login'); // Example default
        }
        return null;
    }
}
