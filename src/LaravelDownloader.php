<?php

namespace DevNullIr\LaravelDownloader;

use DevNullIr\LaravelDownloader\Database\Models\File_dl;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
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
        if (Storage::exists('laravel-downloader/' . $Path)){
            $getFile = File_dl::where('path', $Path)->get();
            if ($getFile->count() == 1) {
                $getFile->delete();
                return Storage::disk('local')->delete('laravel-downloader/' . $Path);
            }
        }
        return false;
    }
    public function move(string $From, string $To): bool
    {
        $this->checkFile();
        if (Storage::exists('laravel-downloader/' . $From)){
            $getFile = File_dl::where('path', $From)->get();
            if ($getFile->count() == 1){
                $getFile->update([
                    'path'=>$To
                ]);
                return Storage::disk('local')->move('laravel-downloader/' . $From, 'laravel-downloader/' . $To);
            }
        }
        return false;
    }
    public function Upload(string $ToDirectory,  $request): bool
    {
        $this->checkFile();
        $filename = $request->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filename, PATHINFO_FILENAME);
        // Get just ext
        $extension = $request->getClientOriginalExtension();
        // New file name
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        // Upload Image
        $output = $request->storeAs('laravel-downloader/' . $ToDirectory,$fileNameToStore);
        File_dl::create([
            'path' => $ToDirectory . "/" . $fileNameToStore
        ]);
        return true;
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
