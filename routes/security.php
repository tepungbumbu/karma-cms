<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Security & Rate Limiting
|--------------------------------------------------------------------------
*/

RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});

RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip())->response(function() {
        return response('Too many login attempts. Please try again in a minute.', 429);
    });
});

RateLimiter::for('checkout', function (Request $request) {
    return Limit::perMinute(3)->by($request->ip());
});

// Implementation of IP Blacklist could go here or as a middleware
Route::middleware(['web'])->group(function () {
    // Security related routes if any
});
