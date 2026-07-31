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
        // Ubah public_path ke public_html jika aplikasi berjalan di hosting (struktur folder terpisah)
        $publicPath = null;

        if (isset($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['DOCUMENT_ROOT']) && is_dir($_SERVER['DOCUMENT_ROOT']) && str_contains($_SERVER['DOCUMENT_ROOT'], 'public_html')) {
            $publicPath = $_SERVER['DOCUMENT_ROOT'];
        } elseif (is_dir(base_path('../public_html'))) {
            $publicPath = realpath(base_path('../public_html'));
        }

        if ($publicPath) {
            $this->app->usePublicPath($publicPath);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production' || env('FORCE_HTTPS', false)) {
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

        if (class_exists(\Illuminate\Foundation\Console\ServeCommand::class)) {
            \Illuminate\Foundation\Console\ServeCommand::$passthroughVariables = array_merge(
                \Illuminate\Foundation\Console\ServeCommand::$passthroughVariables,
                ['SystemDrive', 'WINDIR', 'LOCALAPPDATA', 'APPDATA', 'COMSPEC', 'TEMP', 'TMP', 'SystemRoot']
            );
        }
    }
}
