<?php
use \DevNullIr\LaravelDownloader\Facade\LaravelDownloaderFacade as LaravelDownloader;

if(! function_exists('purchased')){
    function purchased(int $user_id, int $file_id, int $count = 1): bool{
        return LaravelDownloader::purchased($user_id, $file_id, $count);
    }
}

if (! function_exists('GeneralPurchased')){
    function GeneralPurchased(int $file_id): bool|int{
        return LaravelDownloader::GeneralPurchased($file_id);
    }
}

if (! function_exists('Download_ld')){
    function Download_ld(string $DownloadToken){
        return LaravelDownloader::Download($DownloadToken);
    }
}
