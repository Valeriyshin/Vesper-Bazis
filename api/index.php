<?php
// Vercel: /tmp is the only writable directory
$dbPath = '/tmp/database.sqlite';

// Override DB path before Laravel boots
putenv("DB_DATABASE=$dbPath");
$_ENV['DB_DATABASE'] = $dbPath;
$_SERVER['DB_DATABASE'] = $dbPath;

// Blade compiled views must also go to /tmp
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}

// On cold start the /tmp is empty — migrate and seed
if (!file_exists($dbPath) || filesize($dbPath) < 1000) {
    touch($dbPath);
    $php = PHP_BINARY;
    $root = dirname(__DIR__);
    shell_exec("'$php' '$root/artisan' migrate --force 2>&1");
    shell_exec("'$php' '$root/artisan' db:seed --class=RuLangSeeder --force 2>&1");
    shell_exec("'$php' '$root/artisan' db:seed --class=KkLangSeeder --force 2>&1");
    shell_exec("'$php' '$root/artisan' db:seed --class=FamilyClubSeeder --force 2>&1");
    shell_exec("'$php' '$root/artisan' db:seed --class=ProgressStageSeeder --force 2>&1");
}

$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../public';
require __DIR__ . '/../public/index.php';
