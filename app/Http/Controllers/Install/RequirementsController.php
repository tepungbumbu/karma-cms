<?php declare(strict_types=1);

namespace App\Http\Controllers\Install;

use Illuminate\Contracts\View\View;

class RequirementsController extends InstallController
{
    public function index(): View
    {
        $requirements = [
            'php' => [
                'name' => 'PHP Version (8.2+)',
                'satisfied' => version_compare(PHP_VERSION, '8.2.0', '>='),
                'value' => PHP_VERSION,
            ],
            'extensions' => [
                'pdo_mysql' => extension_loaded('pdo_mysql'),
                'mbstring' => extension_loaded('mbstring'),
                'xml' => extension_loaded('xml'),
                'ctype' => extension_loaded('ctype'),
                'json' => extension_loaded('json'),
                'tokenizer' => extension_loaded('tokenizer'),
                'gd' => extension_loaded('gd'),
                'curl' => extension_loaded('curl'),
            ],
            'permissions' => [
                'storage' => is_writable(storage_path()),
                'cache' => is_writable(bootstrap_path('cache')),
                'env' => is_writable(base_path('.env')) || is_writable(base_path()),
            ],
            'settings' => [
                'memory_limit' => $this->getMemoryLimit() >= 256,
                'max_execution_time' => ini_get('max_execution_time') >= 300 || ini_get('max_execution_time') == 0,
            ]
        ];

        return view('installer.requirements', compact('requirements'));
    }

    private function getMemoryLimit(): int
    {
        $memory_limit = ini_get('memory_limit');
        if (preg_match('/^(\d+)(.)$/', $memory_limit, $matches)) {
            if ($matches[2] == 'G') {
                return (int) $matches[1] * 1024;
            } elseif ($matches[2] == 'M') {
                return (int) $matches[1];
            } elseif ($matches[2] == 'K') {
                return (int) round((int) $matches[1] / 1024);
            }
        }
        return (int) $memory_limit;
    }
}
