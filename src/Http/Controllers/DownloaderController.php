<?php

namespace DevNullIr\LaravelDownloader\Http\Controllers;

use DevNullIr\LaravelDownloader\Database\Models\Permissions_file;
use DevNullIr\LaravelDownloader\Database\Models\purchased;
use DevNullIr\LaravelDownloader\Facade\LaravelDownloaderFacade;
use Illuminate\Support\Facades\Storage;

class DownloaderController extends BaseController
{
    public function download(string $DownloadToekn)
    {
        $check_file = Permissions_file::where('token', $DownloadToekn)->get();
        if ($check_file->count() == 1){
            echo time();
            return Storage::download('laravel-downloader/imgs/screenshot.PNG');
        }else{
            abort(404);
        }
    }

    public function Config()
    {
        $array = [];
        $array[] = LaravelDownloaderFacade::makeDirectory('public');
        $array[] = LaravelDownloaderFacade::makeDirectory('imgs');
        $array[] = LaravelDownloaderFacade::makeDirectory('fonts');
        $array[] = LaravelDownloaderFacade::makeDirectory('others');
        return $array;
    }
}
