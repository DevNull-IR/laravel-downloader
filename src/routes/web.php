<?php
use Illuminate\Support\Facades\Route;
use \DevNullIr\LaravelDownloader\Http\Controllers\DownloaderController;


Route::group(['middleware' => 'web'],function (){
    if (config('LaravelDownloader.showDownloadRoute')){
        Route::get('/' . config('LaravelDownloader.download_route') . '/{DownloadToekn}', [DownloaderController::class, 'download'])->name('laravelDownloaderDl');
    }
});
