<?php

return [
    /*
     * |--------------------------------------------------------------------------
     * | Shared Hosting Optimization
     * |--------------------------------------------------------------------------
     * |
     * | Settings for shared hosting environments like Hostdata.id, DirectAdmin, etc.
     * |
     */
    'hosting' => [
        'type' => env('KARMA_HOSTING_TYPE', 'shared'),
        'optimize' => env('KARMA_HOSTING_OPTIMIZE', true),
        'db_retries' => 3,
    ],

    /*
     * |--------------------------------------------------------------------------
     * | Module Management
     * |--------------------------------------------------------------------------
     * |
     * | Configuration for the plug-and-play module system.
     * |
     */
    'modules' => [
        'path' => base_path('modules'),
        'cache' => true,
    ],

    /*
     * |--------------------------------------------------------------------------
     * | Installer Configuration
     * |--------------------------------------------------------------------------
     * |
     */
    'installer' => [
        'envato_verify' => true,
        'demo_data' => true,
    ],

    /*
     * |--------------------------------------------------------------------------
     * | Security Layer
     * |--------------------------------------------------------------------------
     * |
     */
    'security' => [
        'admin_prefix' => 'admin',
        'max_login_attempts' => 5,
    ],
];
