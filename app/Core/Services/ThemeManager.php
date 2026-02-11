<?php declare(strict_types=1);

namespace App\Core\Services;

use App\Core\Models\Theme;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Collection;

/**
 * Class ThemeManager
 *
 * Handles theme discovery, activation, and asset/view resolution.
 */
class ThemeManager
{
    protected string $themePath;

    public function __construct()
    {
        $this->themePath = resource_path('themes');
    }

    /**
     * Discover all themes in the themes directory.
     */
    public function discover(): Collection
    {
        if (!File::exists($this->themePath)) {
            File::makeDirectory($this->themePath, 0755, true);
        }

        $directories = File::directories($this->themePath);
        $themes = collect();

        foreach ($directories as $directory) {
            $manifestPath = $directory . '/theme.json';
            if (File::exists($manifestPath)) {
                $manifest = json_decode(File::get($manifestPath), true);
                if ($manifest) {
                    $manifest['slug'] = basename($directory);
                    $manifest['path'] = $directory;
                    $manifest['screenshot'] = File::exists($directory . '/screenshot.png')
                        ? asset('themes/' . $manifest['slug'] . '/screenshot.png')
                        : null;
                    $themes->push($manifest);
                }
            }
        }

        return $themes;
    }

    /**
     * Activate a theme by slug.
     */
    public function activate(string $slug): bool
    {
        $theme = $this->discover()->where('slug', $slug)->first();
        if (!$theme) {
            return false;
        }

        // Deactivate all others
        Theme::query()->update(['is_active' => false]);

        // Update or create in DB
        Theme::updateOrCreate(
            ['slug' => $slug],
            [
                'name' => $theme['name'],
                'version' => $theme['version'] ?? '1.0.0',
                'is_active' => true,
                'path' => $theme['path'],
            ]
        );

        $this->clearCache();
        return true;
    }

    /**
     * Get the currently active theme.
     */
    public function getActive(): ?Theme
    {
        return Cache::remember('active_theme', 3600, function () {
            return Theme::active()->first() ?: Theme::where('is_default', true)->first();
        });
    }

    /**
     * Clear theme related cache.
     */
    public function clearCache(): void
    {
        Cache::forget('active_theme');
        // Clear compiled views if necessary
        // Artisan::call('view:clear');
    }

    /**
     * Resolve a view path with fallback to core or default theme.
     */
    public function getView(string $view): string
    {
        $activeTheme = $this->getActive();
        if ($activeTheme) {
            $themeView = 'theme::' . $view;
            if (View::exists($themeView)) {
                return $themeView;
            }
        }

        return $view;
    }

    /**
     * Save theme customizer settings.
     */
    public function customize(string $slug, array $settings): bool
    {
        $theme = Theme::where('slug', $slug)->first();
        if (!$theme) {
            return false;
        }

        $theme->update(['settings' => array_merge($theme->settings ?? [], $settings)]);
        $this->clearCache();

        return true;
    }

    /**
     * Get theme specific asset URL.
     */
    public function asset(string $path): string
    {
        $active = $this->getActive();
        if (!$active)
            return asset($path);

        return asset("themes/{$active->slug}/{$path}");
    }

    /**
     * Register theme view namespace and fallbacks.
     */
    public function registerThemeViews(): void
    {
        $activeTheme = $this->getActive();
        if ($activeTheme && File::exists($activeTheme->path . '/views')) {
            View::addNamespace('theme', $activeTheme->path . '/views');

            // Allow theme to override core module views
            // Typical path: theme/views/modules/blog/index.blade.php
            $overridePath = $activeTheme->path . '/views/modules';
            if (File::exists($overridePath)) {
                $modules = File::directories($overridePath);
                foreach ($modules as $modulePath) {
                    $moduleName = basename($modulePath);
                    View::prependNamespace($moduleName, $modulePath);
                }
            }
        }
    }
}
