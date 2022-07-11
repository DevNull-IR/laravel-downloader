<?php

namespace DevNullIr\LaravelDownloader;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LaravelDownloader
{
    public function All(): array
    {
        return ["Files" => Storage::allFiles('laravel-downloader'), "Directories" => Storage::allDirectories('laravel-downloader')];
    }

    public function allFiles(string|null $directory = null): array
    {
        return Storage::allFiles('laravel-downloader/' . $directory);
    }
    public function put(string $Path, $content): bool
    {

        $this->checkFile();
        return Storage::disk('local')->put('laravel-downloader/' . $Path, $content);
    }
    public function append(string $Path, $content): bool
    {
        $this->checkFile();
        return Storage::disk('local')->append('laravel-downloader/' . $Path, $content);
    }
    public function delete(string $Path): bool
    {
        $this->checkFile();
        return Storage::disk('local')->delete('laravel-downloader/' . $Path);
    }
    public function move(string $From, string $To): bool
    {
        $this->checkFile();
        return Storage::disk('local')->move('laravel-downloader/' . $From, 'laravel-downloader/' . $To);
    }
    public function copy(string $From, string $To): bool
    {
        $this->checkFile();

        return Storage::disk('local')->copy('laravel-downloader/' . $From, 'laravel-downloader/' . $To);
    }
    public function exists(string $Path): bool
    {
        $this->checkFile();
        return Storage::exists('laravel-downloader/' . $Path);
    }
    public function checkFile(): bool
    {
        if (!Storage::exists('laravel-downloader')){
            Storage::makeDirectory('laravel-downloader');
            return true;
        }
        return false;
    }
    public function makeDirectory(string $Directory): array
    {
        if (!Storage::exists('laravel-downloader')){
            Storage::makeDirectory('laravel-downloader');
        }
        if (!Storage::exists('laravel-downloader/' . $Directory)){
            Storage::makeDirectory('laravel-downloader/' . $Directory);
            return [
                    'result' => true,
                    'message' => "Directory Create Success"
                ];
        }else{
            return [
                'result' => false,
                'message' => "Directory Already"
            ];
        }
    }
}
