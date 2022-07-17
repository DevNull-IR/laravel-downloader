<?php

namespace DevNullIr\LaravelDownloader\Facade;


use Illuminate\Support\Facades\Facade;

/**
 * class LaravelDownloaderFacade
 *
 * @method static bool append(string $Path, $content)
 * @method static bool delete(string $Path, $content)
 * @method static bool move(string $From, string $To)
 * @method static bool|object Upload(string $ToDirectory,  $request)
 * @method static bool|object put(string $Path, $content)
 * @method static array makeDirectory(string $Directory)
 * @method static array All()
 * @method static array allFiles(string|null $directory = null)
 * @method static bool|object purchased(int $file_id, int $count = 1)
 * @method static bool|object GeneralPurchased(int $file_id):
 * @method static Download(string $DownloadToekn)
 * @method static array|bool|object registerToken(int $purchased_id)
 * @method static array|bool|object registerTokenGeneral(int $purchased_id)
 * @method static bool exists(string $Path)
 * @method static bool checkFile()
 * @method static array|bool|object zipArchive(array $config = ['zipName' => 'ZipArchive', 'removed' => false], array $files = [])
 * @method static bool|object makeCourse(string $CourseName, string $CoursePath)
 * @method static string|bool getDurationCourse(int $Course_ID)
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
