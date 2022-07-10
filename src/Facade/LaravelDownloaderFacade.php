<?php

namespace DevNullIr\LaravelDownloader\Facade;


use Illuminate\Support\Facades\Facade;

/**
 * class LaravelDownloaderFacade
 *
 * @method static array newDirectory()
 *
 * @see \DevNullIr\LaravelDownloader\
 * @package DevNullIr\LaravelDownloader\Facade
 */
class LaravelDownloaderFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "LaravelDownloader";
    }
}
