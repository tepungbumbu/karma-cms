<?php

namespace App\Core\Security;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SecurityManager
{
    /**
     * Sanitize input strings to prevent XSS
     */
    public function sanitizeInput(string $input, array $allowedTags = []): string
    {
        return strip_tags($input, $allowedTags);
    }

    /**
     * Audit and log potentially unsafe raw queries
     */
    public function auditRawQuery(string $query, array $bindings = []): void
    {
        if (Str::contains(Str::lower($query), ['delete', 'drop', 'truncate', 'alter'])) {
            Log::warning('Potentially dangerous raw query detected: ' . $query, [
                'bindings' => $bindings,
                'user_id' => auth()->id(),
                'ip' => request()->ip()
            ]);
        }
    }

    /**
     * Force parameter binding on raw queries
     */
    public function safeRaw(string $query, array $bindings = [])
    {
        $this->auditRawQuery($query, $bindings);
        return DB::select(DB::raw($query), $bindings);
    }

    /**
     * Sanitize file names for upload
     */
    public function sanitizeFileName(string $fileName): string
    {
        return Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
    }

    /**
     * Log administrative actions
     */
    public function logAdminAction(string $action, string $model = null, int $modelId = null, array $details = []): void
    {
        Log::channel('security')->info('Admin action: ' . $action, [
            'admin_id' => auth()->id(),
            'model' => $model,
            'model_id' => $modelId,
            'details' => $details,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }
}
