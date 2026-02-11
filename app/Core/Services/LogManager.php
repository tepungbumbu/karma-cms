<?php

namespace App\Core\Services;

use Illuminate\Support\Facades\Log;

class LogManager
{
    /**
     * Log an event with structured data
     */
    public function log(string $message, array $context = [], string $level = 'info', string $channel = 'daily'): void
    {
        Log::channel($channel)->log($level, $message, array_merge($context, [
            'timestamp' => now()->toIso8601String(),
            'memory_usage' => memory_get_usage(true),
        ]));
    }

    /**
     * Log security specific event
     */
    public function security(string $message, array $context = []): void
    {
        $this->log($message, $context, 'warning', 'security');
    }

    /**
     * Log module specific event
     */
    public function module(string $module, string $message, array $context = []): void
    {
        $this->log("[{$module}] " . $message, $context, 'info', 'modules');
    }

    /**
     * Get recent logs (for admin viewer)
     */
    public function getRecentLogs(string $channel = 'daily', int $lines = 100): array
    {
        $logFile = storage_path("logs/{$channel}.log");
        if (!file_exists($logFile)) {
            return [];
        }

        $data = file($logFile);
        return array_slice($data, -$lines);
    }
}
