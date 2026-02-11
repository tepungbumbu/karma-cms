<?php

/**
 * KarmaCMS Permission Fix Helper
 * Used for shared hosting environments to ensure storage and cache are writable.
 */

$paths = [
    'storage',
    'storage/app',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'bootstrap/cache',
];

echo "<h1>KarmaCMS Permission Fixer</h1>";
echo "<ul>";

foreach ($paths as $path) {
    $fullPath = __DIR__ . '/' . $path;
    if (file_exists($fullPath)) {
        if (chmod($fullPath, 0775)) {
            echo "<li><span style='color:green'>✓</span> Fixed: <strong>{$path}</strong> (0775)</li>";
        } else {
            echo "<li><span style='color:red'>✗</span> Failed: <strong>{$path}</strong></li>";
        }
    } else {
        echo "<li><span style='color:orange'>!</span> Missing: <strong>{$path}</strong></li>";
    }
}

echo "</ul>";
echo "<p>Permissions update completed. If errors persist, please contact your host to ensure the web server has write access to these folders.</p>";
