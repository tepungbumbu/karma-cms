<?php

use App\Http\Controllers\Install\AdminController;
use App\Http\Controllers\Install\CompletionController;
use App\Http\Controllers\Install\DatabaseController;
use App\Http\Controllers\Install\EnvironmentController;
use App\Http\Controllers\Install\LicenseController;
use App\Http\Controllers\Install\MigrationController;
use App\Http\Controllers\Install\ModuleSelectionController;
use App\Http\Controllers\Install\RequirementsController;
use App\Http\Controllers\Install\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('install')->name('install.')->group(function () {
    Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

    Route::get('/requirements', [RequirementsController::class, 'index'])->name('requirements');

    Route::get('/license', [LicenseController::class, 'index'])->name('license');
    Route::post('/license', [LicenseController::class, 'store'])->name('license.post');

    Route::get('/database', [DatabaseController::class, 'index'])->name('database');
    Route::post('/database', [DatabaseController::class, 'store'])->name('database.post');

    Route::get('/environment', [EnvironmentController::class, 'index'])->name('environment');
    Route::post('/environment', [EnvironmentController::class, 'store'])->name('environment.post');

    Route::get('/migrations', [MigrationController::class, 'index'])->name('migrations');
    Route::post('/migrations', [MigrationController::class, 'run'])->name('migrations.run');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.post');

    Route::get('/modules', [ModuleSelectionController::class, 'index'])->name('modules');
    Route::post('/modules', [ModuleSelectionController::class, 'store'])->name('modules.post');

    Route::get('/completion', [CompletionController::class, 'index'])->name('completion');
});
