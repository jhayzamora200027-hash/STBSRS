<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        if ($request->isSecure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=63072000; includeSubDomains'
            );
        }
        $response->headers->set('Permissions-Policy', 'camera=(), geolocation=(), microphone=()');
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self'; " .
            "base-uri 'self'; frame-ancestors 'none'; object-src 'none'; " .
            "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://code.jquery.com http://127.0.0.1:5173 http://127.0.0.1:5174; " .
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com http://127.0.0.1:5173 http://127.0.0.1:5174; " .
            "font-src 'self' https://cdn.jsdelivr.net https://fonts.gstatic.com data:; " .
            "img-src 'self' data: blob:; connect-src 'self' https://cdn.jsdelivr.net http://127.0.0.1:5173 ws://127.0.0.1:5173 http://127.0.0.1:5174 ws://127.0.0.1:5174;"
        );

        return $response;
    }
}
