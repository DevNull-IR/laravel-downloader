<?php
use Illuminate\Support\Facades\Route;
use \DevNullIr\LaravelDownloader\Http\Controllers\DownloaderController;


Route::group(['middleware' => 'web'],function (){
    if (config('LaravelDownloader.showDownloadRoute')){
        if (config('LaravelDownloader.showView')) {
            Route::get('/' . config('LaravelDownloader.thank_route') . '/{DownloadToekn}', [DownloaderController::class, 'thank_dl'])->name('thank_dl');
        }
        Route::get('/' . config('LaravelDownloader.download_route') . '/{DownloadToekn}', [DownloaderController::class, 'dl'])->name('laravelDownloaderDl');
    }
});
