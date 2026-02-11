<?php declare(strict_types=1);

namespace Karma\Blog\Hooks;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class InstallHook
{
    public function handle(): void
    {
        Log::info('Blog module installation hook triggered.');

        // Run migrations
        Artisan::call('migrate', [
            '--path' => 'modules/Blog/Database/Migrations',
            '--force' => true,
        ]);

        // Publish assets if needed
        Log::info('Blog module migrations completed.');
    }
}
