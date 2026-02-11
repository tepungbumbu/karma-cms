<?php declare(strict_types=1);

namespace App\Core\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Class SharedHostingOptimizer
 *
 * Specifically designed to handle database drops, file-based cache bloat,
 * and session garbage collection on restrictive shared hosting environments.
 */
class SharedHostingOptimizer
{
    /**
     * Attempt a database operation with retries.
     * Useful for shared hosting MySQL which frequently drops connections.
     */
    public function retryDb(callable $callback, int $attempts = 3)
    {
        $lastException = null;

        for ($i = 0; $i < $attempts; $i++) {
            try {
                return $callback();
            } catch (Exception $e) {
                $lastException = $e;
                if ($i < $attempts - 1) {
                    sleep(1);  // Wait a second before retry
                    DB::reconnect();
                }
            }
        }

        throw $lastException;
    }

    /**
     * Perform garbage collection on file-based cache.
     * Shared hosting storage/framework/cache can grow huge.
     */
    public function gcCache(): void
    {
        $path = storage_path('framework/cache/data');
        if (!File::exists($path)) {
            return;
        }

        // Implementation to remove expired cache files if directory is too large
        $this->removeOldFiles($path, 24);  // Older than 24 hours
    }

    /**
     * Clean up database sessions manually (if cron isn't reliable).
     */
    public function gcSessions(): void
    {
        try {
            DB::table('sessions')
                ->where('last_activity', '<', time() - config('session.lifetime') * 60)
                ->delete();
        } catch (Exception $e) {
            Log::warning('Session cleanup failed: ' . $e->getMessage());
        }
    }

    /**
     * Rotate logs to prevent storage exhaustion.
     */
    public function rotateLogs(): void
    {
        $logFile = storage_path('logs/laravel.log');
        if (File::exists($logFile) && File::size($logFile) > 10 * 1024 * 1024) {  // 10MB
            $backupFile = storage_path('logs/laravel-' . date('Y-m-d') . '.log');
            File::move($logFile, $backupFile);
            File::put($logFile, '');
        }
    }

    /**
     * Recursively remove old files from a directory.
     */
    private function removeOldFiles(string $directory, int $hours): void
    {
        foreach (File::allFiles($directory) as $file) {
            if ($file->getMTime() < (time() - ($hours * 3600))) {
                File::delete($file->getPathname());
            }
        }
    }
}
