<?php

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', [Controller::class, 'home'])->name('home');
Route::get('/progress', [Controller::class, 'progress'])->name('progress');
Route::get('/check', [Controller::class, 'check']);

Route::post('/flat', [Controller::class, 'flat'])->name('flat');


Route::get('/sl', function () {
//    Artisan::call('storage:link');
//    Artisan::call('migrate --force');
//    $seder = new \Database\Seeders\RuLangSeeder();
//    $seder->run();
    $seder = new \Database\Seeders\PlansLangSeeder();
    $seder->run();
//    Artisan::call('filament:optimize');
//    echo 'fo';
});


Route::get('/relapp', function () {
    echo 'relapp';
    Artisan::call('app:reload-apartments --wipe');
    foreach (Apartment::all() as $apartment){
        echo $apartment->toJson(JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        echo '---'.PHP_EOL;
        echo json_encode($apartment->payload);
        echo str_repeat(PHP_EOL, 3);
    }
});

Route::get('/check', [Controller::class, 'checkCache']);
