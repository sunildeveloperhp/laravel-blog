<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Log;

class LogFailedLogin
{
    // Laravel fires the Failed event when a login attempt has the wrong email or password
    public function handle(Failed $event): void
    {
        Log::channel('security')->warning('Failed login', [
            'email' => $event->credentials['email'] ?? null,   // NEVER log the password
            'guard' => $event->guard,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
