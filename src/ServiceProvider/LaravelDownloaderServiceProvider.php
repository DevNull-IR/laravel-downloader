<?php

namespace DevNullIr\LaravelDownloader\ServiceProvider;

use DevNullIr\LaravelDownloader\LaravelDownloader;
use Illuminate\Support\ServiceProvider;

class LaravelDownloaderServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('LaravelDownloader',function (){
            return new LaravelDownloader();
        });
        $this->mergeConfigFrom(__DIR__ . "/../core/config/config.php", 'LaravelDownloader');
    }
    /**
     * boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . "/../routes/web.php");
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
        $this->publishes([
            __DIR__ . "/../core/config/config.php" => config_path("LaravelDownloader.php")
        ],'LaravelDownloaderConfig');
        $this->publishes([
            __DIR__ . "/../Database/migrations" => database_path("migrations")
        ],'LaravelDownloaderMigrations');
    }
}
