<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Karma\Blog\Http\Controllers\Frontend\BlogController;

Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('blog/search', [BlogController::class, 'search'])->name('blog.search');
Route::get('blog/tag/{tag:slug}', [BlogController::class, 'tag'])->name('blog.tag');
Route::get('blog/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('blog/{category:slug}/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
