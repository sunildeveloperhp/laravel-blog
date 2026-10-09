<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrustFrontendClientIp
{
    // Every API call comes from the Next.js server, so Laravel would see one IP for all visitors.
    // Next.js sends the visitor's IP in X-Client-IP. We only believe it when the shared secret matches,
    // otherwise anyone could send a fake IP and get around the rate limits.
    public function handle(Request $request, Closure $next): Response
    {
        $secret = config('services.frontend.secret');
        $clientIp = $request->header('X-Client-IP');

        if (
            $secret
            && $clientIp
            && hash_equals($secret, (string) $request->header('X-Frontend-Secret'))
            && filter_var($clientIp, FILTER_VALIDATE_IP)
        ) {
            // From here on, $request->ip() (rate limits, logs) returns the visitor's IP
            $request->server->set('REMOTE_ADDR', $clientIp);
        }

        return $next($request);
    }
}
