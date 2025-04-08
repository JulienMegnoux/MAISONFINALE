<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

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
        // Évite les erreurs SQLite concernant les index trop longs
        Schema::defaultStringLength(191);

        // Partager les paramètres de la plateforme dans toutes les vues
        View::composer('*', function ($view) {
            $settings = Setting::first();
            $view->with('settings', $settings);
        });
    }
}
