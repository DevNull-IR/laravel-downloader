<?php

namespace DevNullIr\LaravelDownloader\Http\Controllers;

use DevNullIr\LaravelDownloader\Facade\LaravelDownloaderFacade;

class DownloaderController extends BaseController
{
    public function download(string $DownloadToekn)
    {
        $this->Config();
        return $DownloadToekn;
    }

    public function Config()
    {
        LaravelDownloaderFacade::newDirectory('public');
        LaravelDownloaderFacade::newDirectory('imgs');
        LaravelDownloaderFacade::newDirectory('fonts');
        LaravelDownloaderFacade::newDirectory('file');
    }
}
