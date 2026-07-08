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
        if (config('app.env') === 'production' || env('FORCE_HTTPS', true)) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('contacts')) {
                $globalContact = \App\Models\Contact::first();
                \Illuminate\Support\Facades\View::share('globalContact', $globalContact);
            }
        } catch (\Exception $e) {
            // Ignore for initial migrations
        }
    }
}
