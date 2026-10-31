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
        \Illuminate\Pagination\Paginator::defaultView('vendor.pagination.custom');

        if (config('app.env') === 'production' || env('FORCE_HTTPS', false) || !app()->isLocal()) {
            \Illuminate\Support\Facades\URL::forceScheme('https');

            $appUrl = config('app.url');
            if ($appUrl) {
                if (str_starts_with($appUrl, '//')) {
                    $appUrl = 'https:' . $appUrl;
                } elseif (!str_starts_with($appUrl, 'http://') && !str_starts_with($appUrl, 'https://')) {
                    $appUrl = 'https://' . ltrim($appUrl, '/');
                }
                config(['app.url' => $appUrl]);
                \Illuminate\Support\Facades\URL::forceRootUrl($appUrl);
            }
        }

        if (!$this->app->runningInConsole()) {
            \Illuminate\Support\Facades\View::composer('*', function ($view) {
                static $resolved = false;
                static $globalContact = null;

                if (!$resolved) {
                    $resolved = true;
                    try {
                        if (\Illuminate\Support\Facades\Schema::hasTable('contacts')) {
                            $globalContact = \App\Models\Contact::first();
                        }
                    } catch (\Throwable $e) {
                        // Ignore database connection issues during boot/render
                    }
                }

                $view->with('globalContact', $globalContact);
            });
        }

        if (class_exists(\Illuminate\Foundation\Console\ServeCommand::class)) {
            \Illuminate\Foundation\Console\ServeCommand::$passthroughVariables = array_merge(
                \Illuminate\Foundation\Console\ServeCommand::$passthroughVariables,
                ['SystemDrive', 'WINDIR', 'LOCALAPPDATA', 'APPDATA', 'COMSPEC', 'TEMP', 'TMP', 'SystemRoot']
            );
        }
    }
}
