<?php

namespace Fauzantaqiyuddin\LaravelMinio;

use Illuminate\Support\ServiceProvider;

class MiniojanServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    // public function register()
    // {
    //     $this->app->singleton(Miniojan::class, function ($app) {
    //         return new Miniojan(
    //             config('miniojan.endpoint'),
    //             config('miniojan.access_key'),
    //             config('miniojan.secret_key'),
    //             config('miniojan.region')
    //         );
    //     });
    // }

    // /**
    //  * Bootstrap services.
    //  *
    //  * @return void
    //  */
    // public function boot()
    // {
    //     $this->publishes([
    //         __DIR__ . '/../config/miniojan.php' => config_path('miniojan.php'),
    //     ], 'config');
    // }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/minio.php', 'minio');

        $this->app->singleton('miniojan', function () {
            return new Miniojan();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/minio.php' => config_path('minio.php'),
        ], 'config');
    }
}
