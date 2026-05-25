<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $newLang = $_GET['lang'] ?? 'ru';
        if(!in_array($newLang, ['ru', 'kk'])) $newLang = 'ru';
        app()->setLocale($newLang);
    }
}
