<?php

/**
 * KarmaCMS Standalone Web Installer Entry Point
 * Used for shared hosting environments without CLI access.
 */

define('LARAVEL_START', microtime(true));

// 1. Check if already installed
if (file_exists(__DIR__ . '/storage/installed')) {
    die('KarmaCMS is already installed. If you want to reinstall, please remove the storage/installed file.');
}

// 2. Requirements Check
$requirements = [
    'PHP Version >= 8.2' => PHP_VERSION_ID >= 80200,
    'BCMath Extension' => extension_loaded('bcmath'),
    'Ctype Extension' => extension_loaded('ctype'),
    'JSON Extension' => extension_loaded('json'),
    'Mbstring Extension' => extension_loaded('mbstring'),
    'OpenSSL Extension' => extension_loaded('openssl'),
    'PDO Extension' => extension_loaded('pdo'),
    'Tokenizer Extension' => extension_loaded('tokenizer'),
    'XML Extension' => extension_loaded('xml'),
    'GD Extension' => extension_loaded('gd'),
    'Fileinfo Extension' => extension_loaded('fileinfo'),
];

// Simple UI for requirements check
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KarmaCMS Installer</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; color: #333; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .installer { background: #fff; padding: 40px; border-radius: 8px; shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 500px; width: 100%; }
        h1 { color: #2b3a4a; margin-top: 0; }
        .requirement { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; }
        .ok { color: green; font-weight: bold; }
        .fail { color: red; font-weight: bold; }
        .btn { display: block; width: 100%; padding: 15px; background: #3498db; color: #fff; text-align: center; text-decoration: none; border-radius: 4px; margin-top: 20px; font-weight: bold; }
        .btn.disabled { background: #ccc; pointer-events: none; }
    </style>
</head>
<body>
    <div class="installer">
        <h1>KarmaCMS Installer</h1>
        <p>Checking system requirements...</p>
        
        <?php $allOk = true; ?>
        <?php foreach ($requirements as $name => $ok): ?>
            <div class="requirement">
                <span><?php echo $name; ?></span>
                <span class="<?php echo $ok ? 'ok' : 'fail'; ?>"><?php echo $ok ? 'OK' : 'FAIL'; ?></span>
            </div>
            <?php if (!$ok) $allOk = false; ?>
        <?php endforeach; ?>

        <?php if ($allOk): ?>
            <a href="/public/index.php" class="btn">Start Installation</a>
        <?php else: ?>
            <div class="fail" style="margin-top:20px;">Please fix the failing requirements to continue.</div>
            <a href="#" class="btn disabled">Start Installation</a>
        <?php endif; ?>
    </div>
</body>
</html>
