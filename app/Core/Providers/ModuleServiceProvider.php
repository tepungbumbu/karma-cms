<?php declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\Models\Module;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

/**
 * Class ModuleServiceProvider
 *
 * Dynamically registers active module routes, views, and migrations.
 */
class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // We will register module service providers here if they define any.
        $this->discoverAndRegisterModules();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Discover enabled modules and register their components.
     */
    protected function discoverAndRegisterModules(): void
    {
        // Use cache to avoid DB hits on every request in shared hosting
        $enabledModules = Cache::rememberForever('karma_modules_enabled', function () {
            try {
                return Module::where('is_enabled', true)->get();
            } catch (\Exception $e) {
                return collect();
            }
        });

        foreach ($enabledModules as $module) {
            $this->registerModule($module);
        }
    }

    /**
     * Register a single module's resources.
     */
    protected function registerModule(Module $module): void
    {
        $slug = $module->slug;
        $studlySlug = Str::studly($slug);
        $modulePath = base_path("modules/{$studlySlug}");

        if (!File::isDirectory($modulePath)) {
            // Fallback to lowercase directory
            $modulePath = base_path("modules/{$slug}");
            if (!File::isDirectory($modulePath)) {
                return;
            }
        }

        // 1. Register Views (e.g., view('blog::index'))
        $viewPath = $modulePath . '/Resources/views';
        if (File::isDirectory($viewPath)) {
            $this->loadViewsFrom($viewPath, $slug);
        }

        // 2. Register Routes
        $this->registerRoutes($modulePath);

        // 3. Register Migrations (Auto-loading for artisan commands)
        $migrationPath = $modulePath . '/Database/Migrations';
        if (File::isDirectory($migrationPath)) {
            $this->loadMigrationsFrom($migrationPath);
        }

        // 4. Load Translations
        $langPath = $modulePath . '/Resources/lang';
        if (File::isDirectory($langPath)) {
            $this->loadTranslationsFrom($langPath, $slug);
        }
    }

    /**
     * Register routes for a module.
     */
    protected function registerRoutes(string $modulePath): void
    {
        $routesPath = $modulePath . '/Routes';

        if (!File::isDirectory($routesPath)) {
            return;
        }

        // Admin Routes
        if (File::exists($routesPath . '/admin.php')) {
            $this->loadRoutesFrom($routesPath . '/admin.php');
        }

        // Web Routes
        if (File::exists($routesPath . '/web.php')) {
            $this->loadRoutesFrom($routesPath . '/web.php');
        }

        // API Routes
        if (File::exists($routesPath . '/api.php')) {
            $this->loadRoutesFrom($routesPath . '/api.php');
        }
    }
}
