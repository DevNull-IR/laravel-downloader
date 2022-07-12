# Laravel Downloader Usage

Download as a token with a specific time for your users or as a public use but as a token and with a specific time

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

# Giving access to a file to the user

Access to only one user

```php
     LaravelDownloader::purchased(file_id, count);
```
The first parameter is the desired file and the second parameter is the number of downloads that a user can do

```php
     LaravelDownloader::purchased(1, 5);
```
It is set for a user who is logged in, otherwise a file will not be registered for the user

**The default value of count is one**

helper function for this method:

`purchased(int $file_id, int $count = 1): bool`

```php
purchased(1,1)
// file 1 With the number of downloads 1
```

**Publish the file publicly to everyone**

```php
LaravelDownloader::GeneralPurchased($file_id);
```

```php
LaravelDownloader::GeneralPurchased(1);

// file 1 Register All User (It is also available for users who have not logged in)
```
helper function for this method:

`GeneralPurchased(int $file_id): bool|int`

```php
GeneralPurchased(1)
// file 1 Register All User (It is also available for users who have not logged in)
```

# Register New Token 

If the user does not have a token, she cannot download, so creating a token for each download is very important

You have to register a token so that a user can start downloading with that token


`LaravelDownloader::registerToken($purchased_id);`

Each user has a purchase ID with which you can create a download token for her

The token you create here is for download and you must introduce it to your user and put it in the user's download link

```php
LaravelDownloader::registerToken(1);

// You must enter the access ID that you gave to the user, and here the ID will be 1
```
# Download File
