<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Other sites can't show our pages inside an <iframe> (stops "clickjacking")
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Browsers must trust our Content-Type and not guess (stops some upload tricks)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Other sites only see our domain in the Referer header, not the full URL
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // We never use the camera, microphone or location, so switch them off
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // On HTTPS only: browsers must always use HTTPS for this site for the next year
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
