<?php declare(strict_types=1);

namespace App\Http\Controllers\Install;

use App\Core\Services\ModuleManager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ModuleSelectionController extends InstallController
{
    public function index(ModuleManager $moduleManager): View
    {
        $modules = $moduleManager->discover();
        return view('installer.modules', compact('modules'));
    }

    public function store(Request $request, ModuleManager $moduleManager): RedirectResponse
    {
        $selectedModules = $request->input('modules', []);

        foreach ($selectedModules as $slug) {
            try {
                $moduleManager->activate($slug);
            } catch (\Exception $e) {
                // Log error and continue or show message
            }
        }

        return redirect()->route('install.completion');
    }
}
