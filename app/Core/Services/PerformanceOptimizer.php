<?php declare(strict_types=1);

namespace App\Core\Services;

use Illuminate\Support\Facades\File;

class PerformanceOptimizer
{
    /**
     * Get critical CSS for inlining.
     */
    public function getCriticalCss(string $theme): string
    {
        $path = resource_path("themes/{$theme}/assets/css/critical.css");
        return File::exists($path) ? File::get($path) : '';
    }

    /**
     * Helper to wrap HTML with minification (simple version).
     */
    public function minifyHtml(string $html): string
    {
        if (config('app.debug')) {
            return $html;
        }

        $search = [
            '/\>[^\S ]+/s',  // strip whitespaces after tags
            '/[^\S ]+\</s',  // strip whitespaces before tags
            '/(\s)+/s',  // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/'  // Remove HTML comments
        ];

        $replace = ['>', '<', '\1', ''];
        return preg_replace($search, $replace, $html);
    }
}
