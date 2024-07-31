<?php

namespace Miniojan;

use Illuminate\Support\ServiceProvider;

class MiniojanServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Miniojan::class, function ($app) {
            return new Miniojan(
                config('miniojan.endpoint'),
                config('miniojan.access_key'),
                config('miniojan.secret_key')
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/miniojan.php' => config_path('miniojan.php'),
        ], 'config');
    }
}
