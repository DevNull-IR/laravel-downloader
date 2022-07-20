# Laravel Downloader Usage

Download as a token with a specific time for your users or as a public use but as a token and with a specific time

# Supported Version
| Package Version | PHP Version |
|---- |----|
| [1.1.0](https://github.com/DevNull-IR/laravel-downloader/releases/tag/1.1.0) | [8.1](https://php.net) |
| [1.0.7](https://github.com/DevNull-IR/laravel-downloader/releases/tag/1.0.7) | [8.1](https://php.net) |
| [1.0.6](https://github.com/DevNull-IR/laravel-downloader/releases/tag/1.0.6) | [8.1](https://php.net) |
| [1.0.5](https://github.com/DevNull-IR/laravel-downloader/releases/tag/1.0.5) | [8.1](https://php.net) |
| [1.0.4](https://github.com/DevNull-IR/laravel-downloader/releases/tag/1.0.4) | [8.1](https://php.net) |
| [1.0.3](https://github.com/DevNull-IR/laravel-downloader/releases/tag/1.0.3) | [8.1](https://php.net) |


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
old version:

```php
'aliases' => [
    ... 
    "LaravelDownloader" => \DevNullIr\LaravelDownloader\Facade\LaravelDownloaderFacade::class,
    ...
];
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
helper function for this method:

`registerToken(int $purchased_id)`

register Token For all Users:

`registerTokenGeneral(int $purchased_id);`

Enter the file ID that is for all users, otherwise the token is not allowed

```php
registerTokenGeneral(1);

// Enter the file ID that is for all users, otherwise the token is not allowed

```

# Zip File

After you have uploaded your file you can zip it

To zip, you need to do the following commands:

```php
LaravelDownloader::zipArchive(array $config = [], array $files = []): array|bool|object
```
In the first parameter, you must enter the settings (as an array)

```php
LaravelDownloader::zipArchive(['zipName'=>"NameFileZip"], array $files = []);
```

**Instead of NameFileZip, you must enter the name you want your zip file to have, otherwise the default value will be used.**

```php
LaravelDownloader::zipArchive(['removed'=>true], array $files = []);
```
The default value is false, if you set this value to true, it will delete the files you zip

```php
LaravelDownloader::zipArchive(['password'=>'domain'], array $files = []);
```
If you enable the ability to set a password for zip files, the password will be activated using this option.

By default, encryption is disabled for zip files. And also the default password is domain.com


***To activate the password function, you can read the configuration section***

# Add file to my zip file

```php
LaravelDownloader::zipArchive(['password'=>'domain'],[8,9,10]);
```
In the second part, you can see the ID of each file

If the output is OK and the zip file is created, a new record will be registered in the database

# Download File

`LaravelDownloader::Download($DownloadToken);`

The token created in the previous step must be entered here

After validation, the download will start

helper function for this method:

`Download_ld(string $DownloadToken)`

***You must return the value to start the download***

You can use the following address for your downloads

`http://yourdomain/dl/{token}`

You can personalize this address as you will learn later

# Create New Course

### info

In version 1.1.0, we have provided a new feature for users to make their work easier and start selling their courses more easily.

Using this part and the next part, you can create a course and then check how many minutes this course is.

## Starting 
```php
public static function makeCourse(string $CourseName, string $CoursePath): bool|object;
```

To create a new course, you need to give the name of that course and the directory address of that course


The directory you see is created automatically by the system itself, you don't need to create it


***This directory is located in storage/app/laravel-downloader***


**Be sure to enter the address you choose for the course in the first parameter when uploading**


```php
LaravelDownloader::makeCourse("learn laravel downloader", "laravel-downloader-course")
```

The output is either `false` or an object from the `eloquent model`


# Get Duration of all videos of a Course

```php
public static function getDurationCourse(int $Course_ID): string|bool;
```

In the first parameter, you must enter the Course ID created in the previous step

The output is either a String or False


If the output value was false, it means that it did not find the course, and if it was String, it means that it has given you the duration of all the videos

# If he is not logged in, he cannot read the article

For this, you only need to enter the content of your article as follows (Enter in the blade):

```blade
...
@ContinueAuth("Content Your Article (You can also write html here.)", "Pleas Logined And Continue (You can also write html here.)", "Parent tag classes of the desired text", "The desired text tag classes")
...
```

# configuration

run this command to terminal:

`php artisan vendor:publish --tag="LaravelDownloaderConfig"`

Now enter the config folder and open the LaravelDownloader.php file

To change the default address of downloads from this file, find the key "download_route" in the returned array and change the value inside it to whatever you want.
Now the default download links have changed.

```php
return [
    ...
    'download_route' => "dl",
    ...
];
```

The special name of this route is "laravelDownloaderDl".

# **Do you want to disable the default route?**

To disable the default route completely, change the value of the "showDownloadRoute" key to false

```php
return [
    ...
    'showDownloadRoute' => true,
    ...
];
```

# Passwords in zip file

To activate this feature, it is necessary to set the "PassFile" value to true in the LaravelDownloader.php file in the config directory.

You can also change the filePassword value to change the default password



# Models

 Course Model namespace:`DevNullIr\LaravelDownloader\Database\Models\Course`


 File List Model namespace:`DevNullIr\LaravelDownloader\Database\Models\File_dl`


 Permissions files Model namespace:`DevNullIr\LaravelDownloader\Database\Models\Permissions_file`


 purchased's Model namespace:`DevNullIr\LaravelDownloader\Database\Models\purchased`
