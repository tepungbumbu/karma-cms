<?php declare(strict_types=1);

namespace App\Http\Controllers\Install;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class CompletionController extends InstallController
{
    public function index(): View
    {
        // Create lock file
        File::put(storage_path('installed.lock'), date('Y-m-d H:i:s'));

        // Clear all caches
        Artisan::call('optimize:clear');

        return view('installer.completion');
    }
}
