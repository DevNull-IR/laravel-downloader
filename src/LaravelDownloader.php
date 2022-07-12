<?php

namespace DevNullIr\LaravelDownloader;

use DevNullIr\LaravelDownloader\Database\Models\File_dl;
use DevNullIr\LaravelDownloader\Database\Models\Permissions_file;
use DevNullIr\LaravelDownloader\Database\Models\purchased;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            $getFile = File_dl::where('path', $From);
            if ($getFile->get()->count() == 1){
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

    public function purchased(int $file_id, int $count = 1): bool|int
    {
        $getFile = File_dl::where('id', $file_id);
        if ($getFile->get()->count() == 1){
            $getUser = \App\Models\User::where('id', Auth::id());
            if ($getUser->get()->count() == 1){
                $getPurchased = purchased::where('user_id', Auth::id())->where('file_id', $file_id);
                if ($getPurchased->get()->count() == 0){
                    purchased::create([
                        'file_id' => $file_id,
                        'user_id' => Auth::id(),
                        'count' => $count
                    ]);
                    $getPurchased = purchased::where('user_id', Auth::id())->where('file_id', $file_id);
                    if ($getPurchased->get()->count() == 1){
                        return $getPurchased->get()[0]->id;
                    }
                    return true;
                }
            }
        }
        return false;
    }
    public function GeneralPurchased(int $file_id): bool|int
    {
        $getFile = File_dl::where('id', $file_id);
        if ($getFile->get()->count() == 1){
            $getPurchased = purchased::where('user_id', 0)->where('file_id', $file_id);
            if ($getPurchased->get()->count() == 0){
                purchased::create([
                    'file_id' => $file_id,
                    'user_id' => 0,
                    'count' => 1
                ]);
                $getPurchased = purchased::where('user_id', 0)->where('file_id', $file_id);
                if ($getPurchased->get()->count() == 1){
                    return $getPurchased->get()[0]->id;
                }
                return true;
            }
        }
        return false;
    }
    public function registerToken(int $purchased_id)
    {
        $getPurchased = purchased::where('id', $purchased_id)->where('user_id', Auth::id());
        if ($getPurchased->count() == 1){
            Permissions_file::create([
                'purchased_id' => $purchased_id,
                'token' => Str::random(rand(5,16)),
                'time' => time()+ (5 * 60)
            ]);
        }
    }



    public function Download(string $DownloadToekn)
    {
        $check_file = Permissions_file::where('token', $DownloadToekn);
        if ($check_file->get()->count() == 1){
            if ($check_file->get()[0]->time >= time()){
                $getPermission = purchased::where('id', $check_file->get()[0]->purchased_id);
                if ($getPermission->get()->count() == 1){
                    $getFile = File_dl::where('id', $getPermission->get()[0]->file_id);
                    if ($getFile->get()->count() == 1){
                        if ($getPermission->get()[0]->count == 0){
                            if ($getPermission->get()[0]->user_id == 0){
                                $check_file->delete();
                                return Storage::download('laravel-downloader/' . $getFile->get()[0]->path);
                            }else{
                                if ($getPermission->get()[0]->user_id == Auth::id()){
                                    $check_file->delete();
                                    return Storage::download('laravel-downloader/' . $getFile->get()[0]->path);
                                }
                            }
                        }elseif($getPermission->get()[0]->count != 0){
                            if ($getPermission->get()[0]->user_id == 0){
                                $check_file->delete();
                                return Storage::download('laravel-downloader/' . $getFile->get()[0]->path);
                            }
                            if ($getPermission->get()[0]->user_id == Auth::id()){
                                if ($getPermission->get()[0]->count - 1 == 0){
                                    $getPermission->delete();
                                }else{
                                    $getPermission->update([
                                        'count' => $getPermission->get()[0]->count - 1
                                    ]);
                                }
                                $check_file->delete();
                                return Storage::download('laravel-downloader/' . $getFile->get()[0]->path);
                            }
                        }
                    }
                }
            }else{
                $check_file->delete();
            }
        }else{
            abort(404);
        }
    }
}
