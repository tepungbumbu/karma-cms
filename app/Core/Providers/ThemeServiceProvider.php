<?php declare(strict_types=1);

namespace App\Core\Providers;

use App\Core\Services\ThemeManager;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ThemeManager::class, function ($app) {
            return new ThemeManager();
        });

        $this->app->singleton(\App\Core\Widgets\WidgetRegistry::class, function ($app) {
            return new \App\Core\Widgets\WidgetRegistry();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Blade::directive('widgetArea', function ($areaId) {
            return "<?php echo app(\App\Core\Widgets\WidgetRegistry::class)->renderArea($areaId); ?>";
        });

        // Don't run if not installed or during console/migrations if schema missing
        if (!file_exists(storage_path('installed')) || !\Illuminate\Support\Facades\Schema::hasTable('themes')) {
            return;
        }

        $manager = $this->app->make(ThemeManager::class);
        $manager->registerThemeViews();

        $this->registerWidgets();
    }

    protected function registerWidgets(): void
    {
        $registry = $this->app->make(\App\Core\Widgets\WidgetRegistry::class);

        $registry->registerWidget('recent_posts', \Karma\Blog\Widgets\RecentPostsWidget::class);
        $registry->registerWidget('newsletter', \App\Core\Widgets\NewsletterWidget::class);
        $registry->registerWidget('social_links', \App\Core\Widgets\SocialLinksWidget::class);
        $registry->registerWidget('custom_html', \App\Core\Widgets\CustomHtmlWidget::class);
        $registry->registerWidget('author_bio', \App\Core\Widgets\AuthorBioWidget::class);

        // Register core areas
        $registry->registerArea('sidebar', 'Main Sidebar');
        $registry->registerArea('footer-1', 'Footer 1');
    }
}
