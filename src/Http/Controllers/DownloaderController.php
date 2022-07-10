<?php

namespace DevNullIr\LaravelDownloader\Http\Controllers;

use DevNullIr\LaravelDownloader\Facade\LaravelDownloaderFacade;

class DownloaderController extends BaseController
{
    public function download(string $DownloadToekn)
    {
        return $DownloadToekn;
    }

    public function Upload()
    {
        LaravelDownloaderFacade::newDirectory('public');
        LaravelDownloaderFacade::newDirectory('imgs');
        LaravelDownloaderFacade::newDirectory('fonts');
        LaravelDownloaderFacade::newDirectory('file');
    }
}
