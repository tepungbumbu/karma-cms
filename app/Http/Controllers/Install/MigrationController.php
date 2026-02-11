<?php declare(strict_types=1);

namespace App\Http\Controllers\Install;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Exception;

class MigrationController extends InstallController
{
    public function index(): View
    {
        return view('installer.migrations');
    }

    public function run(): JsonResponse
    {
        try {
            Artisan::call('migrate', ['--force' => true]);

            // Also seed permissions/roles if needed
            // Artisan::call('db:seed', ['--force' => true]);

            return response()->json(['success' => true, 'message' => 'Migrations completed successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
