<?php
// --- Vercel: all writable paths go to /tmp ---
$tmpDir   = '/tmp/laravel';
$cacheDir = "$tmpDir/bootstrap-cache";
$viewDir  = "$tmpDir/views";
$dbPath   = "$tmpDir/database.sqlite";

foreach ([$cacheDir, $viewDir] as $dir) {
    if (!is_dir($dir)) mkdir($dir, 0755, true);
}

$overrides = [
    'APP_DEBUG'          => 'true',
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

// --- Seed DB on cold start ---
if (!file_exists($dbPath) || filesize($dbPath) < 1000) {
    touch($dbPath);
    $php     = PHP_BINARY;
    $artisan = dirname(__DIR__) . '/artisan';

    $migrateOut = shell_exec("'$php' '$artisan' migrate --force 2>&1");
    $seedOut    = shell_exec("'$php' '$artisan' db:seed --force 2>&1");

    // Show full artisan output so we can diagnose
    header('Content-Type: text/plain');
    die("PHP: $php\nDB: $dbPath (" . filesize($dbPath) . " bytes)\n\n=== MIGRATE ===\n$migrateOut\n=== SEED ===\n$seedOut");
}

$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../public';
require __DIR__ . '/../public/index.php';
