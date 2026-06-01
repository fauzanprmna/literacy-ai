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
        // Set application locale from session or authenticated user
        $locale = session('locale') ?? (auth()->check() ? auth()->user()->language ?? null : null);
        if ($locale) {
            app()->setLocale($locale);
        }

        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
