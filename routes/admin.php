<?php declare(strict_types=1);

use App\Http\Controllers\Admin\ThemeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');  // Placeholder
    })->name('dashboard');

    // Themes
    Route::get('themes', [ThemeController::class, 'index'])->name('themes.index');
    Route::post('themes/activate', [ThemeController::class, 'activate'])->name('themes.activate');

    // Modules will register their own admin routes, or we can include them here
});
