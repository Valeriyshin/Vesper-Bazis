<?php
// Serve static files from public/ directly (Vercel routes all traffic to this file)
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$publicFile  = dirname(__DIR__) . '/public' . $requestPath;

if ($requestPath !== '/'
    && !str_ends_with($requestPath, '.php')
    && file_exists($publicFile)
    && is_file($publicFile)
) {
    $mimes = [
        'css'         => 'text/css; charset=utf-8',
        'js'          => 'application/javascript; charset=utf-8',
        'jpg'         => 'image/jpeg',
        'jpeg'        => 'image/jpeg',
        'png'         => 'image/png',
        'gif'         => 'image/gif',
        'svg'         => 'image/svg+xml',
        'ico'         => 'image/x-icon',
        'woff'        => 'font/woff',
        'woff2'       => 'font/woff2',
        'ttf'         => 'font/ttf',
        'webmanifest' => 'application/manifest+json',
        'txt'         => 'text/plain',
    ];
    $ext  = strtolower(pathinfo($publicFile, PATHINFO_EXTENSION));
    $mime = $mimes[$ext] ?? 'application/octet-stream';
    header('Content-Type: ' . $mime);
    header('Cache-Control: public, max-age=31536000, immutable');
    readfile($publicFile);
    exit;
}

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
