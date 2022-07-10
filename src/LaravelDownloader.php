<?php

namespace DevNullIr\LaravelDownloader;

class LaravelDownloader
{
    public function name()
    {
        return "a";
    }

    public function checkFile(): bool
    {
        if (!file_exists(__DIR__ . "/../../../../storage/laravel-downloader")){
            mkdir(__DIR__ . "/../../../../storage/laravel-downloader");
            return true;
        }
        return false;
    }

    public function newDirectory(string $Directory): array
    {
        if (!file_exists(__DIR__ . "/../../../../storage/laravel-downloader/" . $Directory)){
            if (mkdir(__DIR__ . "/../../../../storage/laravel-downloader/" . $Directory)){
                return [
                    'result' => true,
                    'message' => "Directory Create Success"
                ];
            }
            return [
                'result' => false,
                'message' => "Directory Create Wrong"
            ];

        }
        return [
            'result' => false,
            'message' => "Directory Already"
        ];
    }
}
