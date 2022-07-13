<?php
use \DevNullIr\LaravelDownloader\Facade\LaravelDownloaderFacade as LaravelDownloader;

if(! function_exists('purchased')){
    function purchased(int $file_id, int $count = 1): bool{
        return LaravelDownloader::purchased($file_id, $count);
    }
}

if (! function_exists('GeneralPurchased')){
    function GeneralPurchased(int $file_id): bool|int{
        return LaravelDownloader::GeneralPurchased($file_id);
    }
}
if (! function_exists('registerToken')){
    function registerToken(int $purchased_id){
        return LaravelDownloader::registerToken($purchased_id);
    }
}

if (! function_exists('Download_ld')){
    function Download_ld(string $DownloadToken){
        return LaravelDownloader::Download($DownloadToken);
    }
}
