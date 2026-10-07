<?php

return [

    // Only the API needs CORS. Website pages are never called from other origins.
    'paths' => ['api/*'],

    'allowed_methods' => ['*'],

    // Only our Next.js frontend may read API responses in a browser.
    // Several origins can be listed in .env, separated by commas.
    'allowed_origins' => array_filter(explode(',', env('FRONTEND_URLS', 'http://localhost:3000'))),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    // Let frontend JavaScript read the rate limit headers (hidden from JS by default)
    'exposed_headers' => ['X-RateLimit-Limit', 'X-RateLimit-Remaining', 'Retry-After'],

    // Browsers may remember a successful preflight for 1 hour instead of asking every time
    'max_age' => 3600,

    // We log in with Bearer tokens, not cookies, so browsers don't need to send cookies to the API
    'supports_credentials' => false,

];
