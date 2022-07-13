<?php

namespace DevNullIr\LaravelDownloader\Facade;


use Illuminate\Support\Facades\Facade;

/**
 * class LaravelDownloaderFacade
 *
 * @method static bool append(string $Path, $content)
 * @method static bool delete(string $Path, $content)
 * @method static bool move(string $From, string $To)
 * @method static bool Upload(string $ToDirectory,  $request)
 * @method static bool put(string $Path, $content)
 * @method static array makeDirectory(string $Directory)
 * @method static array All()
 * @method static array allFiles(string|null $directory = null)
 * @method static bool|int purchased(int $file_id, int $count = 1)
 * @method static bool|int GeneralPurchased(int $file_id)
 * @method static Download(string $DownloadToekn)
 * @method static registerToken(int $purchased_id)
 * @method static registerTokenGeneral(int $purchased_id)
 * @method static bool exists(string $Path)
 * @method static bool checkFile()
 *
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
