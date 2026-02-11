<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class PostInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'karma:post-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform post-installation cleanup and optimization';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting KarmaCMS post-installation tasks...');

        // Clear caches
        $this->info('Clearing all caches...');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');

        // Warm up caches
        $this->info('Warming up critical caches...');
        (new \App\Core\Services\CacheManager())->warmup();

        // Create storage link (if possible)
        try {
            $this->info('Creating storage link...');
            Artisan::call('storage:link');
        } catch (\Exception $e) {
            $this->warn('Failed to create storage link. You may need to create it manually.');
        }

        Log::info('Post-installation tasks completed successfully.');
        $this->info('KarmaCMS is ready to go!');
    }
}
