<?php
// Vercel: /tmp is the only writable directory
$tmpDir   = '/tmp/laravel';
$cacheDir = "$tmpDir/bootstrap-cache";
$viewDir  = "$tmpDir/views";
$dbPath   = "$tmpDir/database.sqlite";

foreach ([$cacheDir, $viewDir] as $dir) {
    if (!is_dir($dir)) mkdir($dir, 0755, true);
}

// Redirect all Laravel writable paths to /tmp before the app boots
$overrides = [
    'APP_PACKAGES_CACHE' => "$cacheDir/packages.php",
    'APP_SERVICES_CACHE' => "$cacheDir/services.php",
    'APP_EVENTS_CACHE'   => "$cacheDir/events.php",
    'VIEW_COMPILED_PATH' => $viewDir,
    'DB_DATABASE'        => $dbPath,
];
foreach ($overrides as $key => $val) {
    putenv("$key=$val");
    $_ENV[$key]    = $val;
    $_SERVER[$key] = $val;
}

// On cold start /tmp is empty — migrate + seed
if (!file_exists($dbPath) || filesize($dbPath) < 1000) {
    touch($dbPath);
    $php     = PHP_BINARY;
    $artisan = dirname(__DIR__) . '/artisan';
    shell_exec("'$php' '$artisan' migrate --force 2>&1");
    shell_exec("'$php' '$artisan' db:seed --force 2>&1");
}

$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../public';
require __DIR__ . '/../public/index.php';
