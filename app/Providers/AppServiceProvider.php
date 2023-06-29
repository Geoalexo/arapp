<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Foundation\Vite;
use Illuminate\Support\Facades\Schema;
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
        // Load the filament.css file to enable color theme configuration through tailwind.config.js
        Filament::serving(function () {
            Filament::registerTheme(
                app(Vite::class)('resources/css/app.css'),
            );
        });

        Schema::defaultStringLength(191);
    }
}
