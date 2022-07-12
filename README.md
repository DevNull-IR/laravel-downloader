# Laravel Downloader Usage


# Supported Version
| Package Version | PHP Version |
|---- |----|
| [1.0.2](https://github.com/DevNull-IR/laravel-downloader/releases/tag/1.0.2) | [8.1](https://php.net) |



# Installation

whit composer: ``composer require devnull-ir/laravel-downloader``

**If your Laravel version is higher than 8, there is no need to do this**

Added this Provider ``\DevNullIr\LaravelDownloader\ServiceProvider\LaravelDownloaderServiceProvider::class`` to ``config/app.php``:
```php
'providers' => [
    ... 
    \DevNullIr\LaravelDownloader\ServiceProvider\LaravelDownloaderServiceProvider::class,
    ...
]
```

and added Facade to aliases `"LaravelDownloader" => \DevNullIr\LaravelDownloader\Facade\LaravelDownloaderFacade::class`:
new Version Laravel:

```php
    'aliases' => Facade::defaultAliases()->merge([
        ...
        "LaravelDownloader" => \DevNullIr\LaravelDownloader\Facade\LaravelDownloaderFacade::class
        ...
    ])->toArray(),
```

# Usage

Enter the following command in your terminal

```cmd
php artisan migrate
```

If you are not offered codes, you should use the following facade:

```php
use DevNullIr\LaravelDownloader\Facade\LaravelDownloaderFacade as LaravelDownloader;
```

If you want to upload a file, do the following:


Use in your controller:

```php
use DevNullIr\LaravelDownloader\Facade\LaravelDownloaderFacade as LaravelDownloader;
use \Illuminate\Support\Facades\Request;
```
and change your function controller

```php
public function upload(Request $request){

    LaravelDownloader::Upload("videoPros", $request->file('input'));

}
```

Now your file has been uploaded
