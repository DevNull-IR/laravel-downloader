<?php

namespace DevNullIr\LaravelDownloader\ServiceProvider;

use DevNullIr\LaravelDownloader\LaravelDownloader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        $this->_loadRoutes();
        $this->_loadViews();
        $this->_loadMigrations();
        $this->_publishConfig();
        $this->Authentication();
    }

    /**
     * _publishConfig() Published Config Package
     * @return void
     */
    private function _publishConfig(): void
    {
        $this->publishes([
            __DIR__ . "/../core/config/config.php" => config_path("LaravelDownloader.php")
        ],'LaravelDownloaderConfig');
    }

    /**
     * _loadMigrations() Load And Published Migrations
     * @return void
     */
    private function _loadMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/migrations');
        $this->publishes([
            __DIR__ . "/../Database/migrations" => database_path("migrations")
        ],'LaravelDownloaderMigrations');
    }
    /**
     * _loadRoutes() Load Routes
     * @return void
     */
    private function _loadRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . "/../routes/web.php");
    }
    /**
     * _loadViews() Load And Published Views
     * @return void
     */
    private function _loadViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'LaravelDownloader');
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/LaravelDownloader')
        ],'laravel-downloader-views');
    }
    /**
     * Authentication() Load Blade Template
     * @return void
     */
    protected function Authentication(): void
    {
        Blade::directive('ContinueAuth', function (string $content, string $Message = "please login to Continue", string $classDiv=null, $classP = null) {
                return "<?php
                if(!\Illuminate\Support\Facades\Auth::check()){
                echo substr($content, 0, 150);
                echo '<div class=\\\"$classDiv oh-2\\\"> <p class=\\\"$classP oh-1\\\">{$Message}</p> </div>';
                }else{
                echo $content;
                }
                 ?>";
            });
    }
}
