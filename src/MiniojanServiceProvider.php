<?php

namespace Fauzantaqiyuddin\LaravelMinio;

use Illuminate\Support\ServiceProvider;

class MiniojanServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/miniojan.php', 'minio');

        $this->app->singleton('miniojan', function () {
            return new Miniojan(
                config('miniojan.endpoint'),
                config('miniojan.access_key'),
                config('miniojan.secret_key'),
                config('miniojan.region')
            );
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/miniojan.php' => config_path('minio.php'),
        ], 'config');
    }
}
