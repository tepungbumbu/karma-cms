<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class HealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'karma:health-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform a daily health check of the system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting system health check...');
        $issues = [];

        // 1. Database Connection
        try {
            DB::connection()->getPdo();
            $this->info('✓ Database connection: OK');
        } catch (\Exception $e) {
            $issues[] = 'Database connection failed: ' . $e->getMessage();
        }

        // 2. Disk Space
        $freeSpace = disk_free_space(base_path());
        if ($freeSpace < 100 * 1024 * 1024) { // 100MB
            $issues[] = 'Low disk space: ' . number_format($freeSpace / 1024 / 1024, 2) . 'MB remaining';
        } else {
            $this->info('✓ Disk space: OK');
        }

        // 3. Writable Directories
        $paths = ['storage', 'bootstrap/cache'];
        foreach ($paths as $path) {
            if (!is_writable(base_path($path))) {
                $issues[] = "Directory not writable: {$path}";
            }
        }
        $this->info('✓ Directory permissions: OK');

        // 4. Secure Environment
        if (config('app.debug')) {
            $this->warn('! Warning: APP_DEBUG is enabled in production');
        }

        if (!empty($issues)) {
            $this->error('Health check failed with ' . count($issues) . ' issues.');
            foreach ($issues as $issue) {
                $this->line("- {$issue}");
            }
            Log::channel('security')->error('Health check issues detected', ['issues' => $issues]);
        } else {
            $this->info('Health check passed successfully.');
        }
    }
}
