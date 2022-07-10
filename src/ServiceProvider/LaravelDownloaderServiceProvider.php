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
    }
    /**
     * boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . "/../routes/web.php");

    }
}
