<?php

namespace App\Core\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CacheManager
{
    /**
     * Cache remember wrapper
     */
    public function remember(string $key, int $seconds, callable $callback)
    {
        return Cache::remember($key, $seconds, $callback);
    }

    /**
     * Simulated tags for file driver or other non-taggable drivers
     */
    public function tags(array $tags): self
    {
        $this->currentTags = $tags;
        return $this;
    }

    protected $currentTags = [];

    /**
     * Store item with tags (simulated)
     */
    public function put(string $key, $value, int $seconds): void
    {
        if (!empty($this->currentTags)) {
            foreach ($this->currentTags as $tag) {
                $tagKey = "tag_mapping_{$tag}";
                $keys = Cache::get($tagKey, []);
                if (!in_array($key, $keys)) {
                    $keys[] = $key;
                    Cache::put($tagKey, $keys, now()->addDays(7));
                }
            }
        }
        
        Cache::put($key, $value, $seconds);
        $this->currentTags = [];
    }

    /**
     * Flush by module slug (simulated tags)
     */
    public function flushModule(string $moduleSlug): void
    {
        $tagKey = "tag_mapping_module_{$moduleSlug}";
        $keys = Cache::get($tagKey, []);
        
        foreach ($keys as $key) {
            Cache::forget($key);
        }
        
        Cache::forget($tagKey);
        
        Log::info("Flushed cache context for module: {$moduleSlug}");
    }

    /**
     * Warm up common caches
     */
    public function warmup(): void
    {
        // Example: Cache settings, menus
        $this->remember('global_settings', 3600, function() {
            return \App\Models\Setting::all()->pluck('value', 'key');
        });
    }
}
