<?php

use Illuminate\Support\Facades\Schedule;

// Times use the app timezone (UTC): 02:00 UTC is 07:30 in India.

// Remove Sanctum tokens that expired more than a day ago
Schedule::command('sanctum:prune-expired --hours=24')->daily();

// Remove read notifications older than 90 days
Schedule::command('notifications:prune --days=90')->dailyAt('02:00');

// Remove failed queue jobs older than a week
Schedule::command('queue:prune-failed --hours=168')->weekly();
