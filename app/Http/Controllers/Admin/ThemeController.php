<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Core\Services\ThemeManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ThemeController extends Controller
{
    public function __construct(
        protected ThemeManager $themeManager
    ) {}

    /**
     * Display a listing of available themes.
     */
    public function index(): View
    {
        $themes = $this->themeManager->discover();
        $activeTheme = $this->themeManager->getActive();

        return view('admin.themes.index', compact('themes', 'activeTheme'));
    }

    /**
     * Activate a theme.
     */
    public function activate(Request $request): RedirectResponse
    {
        $slug = $request->input('slug');

        if ($this->themeManager->activate($slug)) {
            return redirect()
                ->route('admin.themes.index')
                ->with('success', "Theme '{$slug}' activated successfully.");
        }

        return redirect()->back()->with('error', 'Failed to activate theme.');
    }
}
