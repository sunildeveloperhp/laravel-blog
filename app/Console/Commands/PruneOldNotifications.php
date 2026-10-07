<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Notifications\DatabaseNotification;

class PruneOldNotifications extends Command
{
    // How to run it: php artisan notifications:prune --days=90
    protected $signature = 'notifications:prune {--days=90 : Delete read notifications older than this many days}';

    protected $description = 'Delete read notifications older than the given number of days';

    public function handle(): int
    {
        $days = (int) $this->option('days');

        $deleted = DatabaseNotification::query()
            ->whereNotNull('read_at')
            ->where('created_at', '<', now()->subDays($days))
            ->delete();

        $this->info("Deleted {$deleted} read notifications older than {$days} days.");

        return self::SUCCESS;
    }
}
