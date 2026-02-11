<?php declare(strict_types=1);

namespace App\Http\Controllers\Install;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class EnvironmentController extends InstallController
{
    public function index(): View
    {
        $dbConfig = session('install_db_config', []);
        return view('installer.environment', compact('dbConfig'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'app_name' => 'required|string',
            'app_url' => 'required|url',
        ]);

        $dbConfig = session('install_db_config');
        if (!$dbConfig) {
            return redirect()->route('install.database');
        }

        $envPath = base_path('.env');
        $envExamplePath = base_path('.env.example');

        $envContent = File::exists($envExamplePath) ? File::get($envExamplePath) : '';

        // Replace Database Config
        $replacements = [
            'APP_NAME' => '"' . $request->app_name . '"',
            'APP_URL' => $request->app_url,
            'DB_HOST' => $dbConfig['host'],
            'DB_DATABASE' => $dbConfig['database'],
            'DB_USERNAME' => $dbConfig['username'],
            'DB_PASSWORD' => $dbConfig['password'] ?? '',
            'DB_PREFIX' => $dbConfig['prefix'] ?? '',
        ];

        foreach ($replacements as $key => $value) {
            $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
        }

        File::put($envPath, $envContent);

        // Generate App Key
        Artisan::call('key:generate', ['--force' => true]);

        return redirect()->route('install.migrations');
    }
}
