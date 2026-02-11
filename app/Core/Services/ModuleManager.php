<?php declare(strict_types=1);

namespace App\Core\Services;

use App\Core\Models\Module;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Exception;

/**
 * Class ModuleManager
 *
 * Handles discovery, validation, activation, deactivation, and uninstallation of modules.
 */
class ModuleManager
{
    private string $modulePath;

    public function __construct()
    {
        $this->modulePath = base_path('modules');

        if (!File::exists($this->modulePath)) {
            File::makeDirectory($this->modulePath, 0755, true);
        }
    }

    /**
     * Discover all modules in the modules directory.
     *
     * @return array<string, array> List of discovered modules with their manifest data.
     */
    public function discover(): array
    {
        $modules = [];
        $directories = File::directories($this->modulePath);

        foreach ($directories as $directory) {
            $manifestPath = $directory . '/module.json';
            if (File::exists($manifestPath)) {
                $manifest = json_decode(File::get($manifestPath), true);
                if ($manifest && isset($manifest['slug'])) {
                    $modules[$manifest['slug']] = $manifest;

                    // Auto-sync with database for discovery
                    $this->syncModuleWithDatabase($manifest);
                }
            }
        }

        return $modules;
    }

    /**
     * Validate module requirements and dependencies.
     *
     * @param string $slug
     * @return bool
     * @throws Exception
     */
    public function validate(string $slug): bool
    {
        $manifest = $this->getManifest($slug);

        // PHP Version Check
        if (isset($manifest['requires']['php'])) {
            if (!phpversion_compare(PHP_VERSION, $manifest['requires']['php'], '>=')) {
                throw new Exception("Module [{$slug}] requires PHP version {$manifest['requires']['php']} or higher.");
            }
        }

        // Dependency Check
        if (isset($manifest['dependencies'])) {
            foreach ($manifest['dependencies'] as $depSlug => $version) {
                $dependency = Module::where('slug', $depSlug)->first();
                if (!$dependency || !$dependency->is_enabled) {
                    throw new Exception("Module [{$slug}] depends on [{$depSlug}] which is missing or disabled.");
                }
            }
        }

        return true;
    }

    /**
     * Activate a module.
     *
     * @param string $slug
     * @return bool
     * @throws Exception
     */
    public function activate(string $slug): bool
    {
        $this->validate($slug);

        $module = Module::where('slug', $slug)->firstOrFail();

        // Run Migrations
        $migrationPath = 'modules/' . Str::studly($slug) . '/Database/Migrations';
        if (File::exists(base_path($migrationPath))) {
            Artisan::call('migrate', [
                '--path' => $migrationPath,
                '--force' => true
            ]);
        }

        $module->update([
            'is_enabled' => true,
            'last_updated' => now()
        ]);

        $this->clearCaches();

        return true;
    }

    /**
     * Deactivate a module.
     *
     * @param string $slug
     * @return bool
     */
    public function deactivate(string $slug): bool
    {
        $module = Module::where('slug', $slug)->firstOrFail();

        $module->update(['is_enabled' => false]);

        $this->clearCaches();

        return true;
    }

    /**
     * Uninstall a module.
     *
     * @param string $slug
     * @return bool
     */
    public function uninstall(string $slug): bool
    {
        $module = Module::where('slug', $slug)->firstOrFail();

        // Rollback Migrations
        $migrationPath = 'modules/' . Str::studly($slug) . '/Database/Migrations';
        if (File::exists(base_path($migrationPath))) {
            Artisan::call('migrate:rollback', [
                '--path' => $migrationPath,
                '--force' => true
            ]);
        }

        // Remove from DB
        $module->delete();

        // Optionally delete files (risky for auto-discovery but complete)
        // File::deleteDirectory($this->modulePath . '/' . Str::studly($slug));

        $this->clearCaches();

        return true;
    }

    /**
     * Resolve dependency tree for a module.
     *
     * @param string $slug
     * @return array
     */
    public function getDependencies(string $slug): array
    {
        $manifest = $this->getManifest($slug);
        return $manifest['dependencies'] ?? [];
    }

    /**
     * Sync discovered module with database state.
     */
    private function syncModuleWithDatabase(array $manifest): void
    {
        Module::updateOrCreate(
            ['slug' => $manifest['slug']],
            [
                'name' => $manifest['name'],
                'version' => $manifest['version'],
                'description' => $manifest['description'] ?? null,
                'is_core' => $manifest['is_core'] ?? false,
                'settings_schema' => $manifest['settings_schema'] ?? null,
                'permissions' => $manifest['permissions'] ?? null,
            ]
        );
    }

    /**
     * Get manifest for a module.
     */
    private function getManifest(string $slug): array
    {
        $path = $this->modulePath . '/' . Str::studly($slug) . '/module.json';
        if (!File::exists($path)) {
            // Try lowercase slug directory
            $path = $this->modulePath . '/' . $slug . '/module.json';
            if (!File::exists($path)) {
                throw new Exception("Module [{$slug}] manifest not found.");
            }
        }

        return json_decode(File::get($path), true);
    }

    /**
     * Clear application caches.
     */
    private function clearCaches(): void
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Cache::forget('karma_modules_enabled');
    }
}
