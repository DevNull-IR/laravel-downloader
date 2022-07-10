<?php

namespace DevNullIr\LaravelDownloader\Http\Controllers;

class DownloaderController extends BaseController
{
    public function download(string $DownloadToekn)
    {
        return $DownloadToekn;
    }
}
