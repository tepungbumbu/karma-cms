<?php declare(strict_types=1);

namespace Karma\Blog\Hooks;

use Illuminate\Support\Facades\Log;

class UninstallHook
{
    public function handle(): void
    {
        Log::info('Blog module uninstallation hook triggered.');
        // Cleanup logic could go here (e.g., deleting settings or specific files)
    }
}
