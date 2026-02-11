<?php declare(strict_types=1);

namespace App\Http\Controllers\Install;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class DatabaseController extends InstallController
{
    public function index(): View
    {
        return view('installer.database');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'host' => 'required',
            'database' => 'required',
            'username' => 'required',
            'password' => 'nullable',
            'prefix' => 'nullable|alpha_dash',
        ]);

        try {
            // Test Connection
            $config = [
                'driver' => 'mysql',
                'host' => $request->host,
                'database' => $request->database,
                'username' => $request->username,
                'password' => $request->password,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => $request->prefix ?? '',
            ];

            config(['database.connections.install_test' => $config]);
            DB::connection('install_test')->getPdo();

            // Store in session for environment step
            session(['install_db_config' => $config]);

            return redirect()->route('install.environment');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Could not connect to the database: ' . $e->getMessage()])->withInput();
        }
    }
}
