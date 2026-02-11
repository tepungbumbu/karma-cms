<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Karma\Blog\Http\Controllers\Admin\PostController;

Route::prefix('blog')->name('admin.blog.')->group(function () {
    Route::resource('posts', PostController::class);
    // Add categories and tags resources here as needed
});
