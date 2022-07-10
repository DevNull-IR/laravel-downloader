<?php
use Illuminate\Support\Facades\Route;
use \DevNullIr\LaravelDownloader\Http\Controllers\DownloaderController;
Route::get('/dl/{DownloadToekn}', [DownloaderController::class, 'download']);
