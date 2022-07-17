<?php

namespace DevNullIr\LaravelDownloader;

use DevNullIr\LaravelDownloader\Database\Models\Course;
use DevNullIr\LaravelDownloader\Database\Models\File_dl;
use DevNullIr\LaravelDownloader\Database\Models\Permissions_file;
use DevNullIr\LaravelDownloader\Database\Models\purchased;
use DevNullIr\LaravelDownloader\Http\VideoSetting\officalVideo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
include_once __DIR__ . "/core/config/video/getid3.php";

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

    public function put(string $Path, $content): bool|object
    {

        $this->checkFile();

        if (Storage::disk('local')->put('laravel-downloader/' . $Path, $content)){
            return File_dl::create([
                'path' => $Path
            ]);
        }
        return false;

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

    public function Upload(string $ToDirectory,  $request): bool|object
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
        return File_dl::create([
            'path' => $ToDirectory . "/" . $fileNameToStore
        ]);
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

    public function purchased(int $file_id, int $count = 1): bool|object
    {
        $getFile = File_dl::where('id', $file_id);
        if ($getFile->get()->count() == 1){
            $getUser = \App\Models\User::where('id', Auth::id());
            if ($getUser->get()->count() == 1){
                $getPurchased = purchased::where('user_id', Auth::id())->where('file_id', $file_id);
                if ($getPurchased->get()->count() == 0){
                    return purchased::create([
                        'file_id' => $file_id,
                        'user_id' => Auth::id(),
                        'count' => $count
                    ]);
                }
            }
        }
        return false;
    }

    public function GeneralPurchased(int $file_id): bool|object
    {
        $getFile = File_dl::where('id', $file_id);
        if ($getFile->get()->count() == 1){
            $getPurchased = purchased::where('user_id', 0)->where('file_id', $file_id);
            if ($getPurchased->get()->count() == 0){
                return purchased::create([
                    'file_id' => $file_id,
                    'user_id' => 0,
                    'count' => 1
                ]);
            }
        }
        return false;
    }

    public function registerToken(int $purchased_id): array|bool|object
    {
        $getPurchased = purchased::where('id', $purchased_id)->where('user_id', Auth::id());
        if ($getPurchased->count() == 1){
            return Permissions_file::create([
                'purchased_id' => $purchased_id,
                'token' => Str::random(rand(5,16)),
                'time' => time()+ (5 * 60)
            ]);
        }
        return false;
    }

	public function registerTokenGeneral(int $purchased_id): array|bool|object
    {
        $getPurchased = purchased::where('id', $purchased_id)->where('user_id', 0);
        if ($getPurchased->count() == 1){
            return Permissions_file::create([
                'purchased_id' => $purchased_id,
                'token' => Str::random(rand(5,16)),
                'time' => time() + (5 * 60)
            ]);
        }
        return false;
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
        }
            abort(404);
    }

    public function zipArchive(array $config = ['zipName' => 'ZipArchive', 'removed' => false], array $files = []): array|bool|object
    {

        $zip = new \ZipArchive;
        $name = $config['zipName'] ?? "ZipArchive" . '_' . time();
        if (!Storage::exists('laravel-downloader/zips')){
            $this->makeDirectory('zips');
        }
        if ($this->exists('zips/' . $name . '.zip')){
            return false;
        }
        if($zip->open(Storage::path('laravel-downloader/zips/' . $name . '.zip'), 1|8) !== true)
            return false;
        foreach ($files as $path_id){
            $files_path = File_dl::where('id', $path_id);
            foreach ($files_path->get() as $indexs){
                if ($this->exists($indexs->path)){
                    $zip->addFile(Storage::path( 'laravel-downloader/' . $indexs->path), basename($indexs->path));
                    if (config('LaravelDownloader.PassFile')){
                        if (isset($config['password'])){
                            $zip->setEncryptionName(basename($indexs->path),\ZipArchive::EM_AES_256, $config['password']);
                        }else{
                            $zip->setEncryptionName(basename($indexs->path),\ZipArchive::EM_AES_256, config('LaravelDownloader.filePassword'));
                        }
                    }
                    if (isset($config['removed']) && $config['removed']){
                        Storage::delete("laravel-downloader/" . $indexs->path);
                        $files_path->delete();
                    }
                }
            }
        }
        $zip->close();

        $file = File_dl::create([
            'path' => 'zips/' . $name . ".zip"
        ]);
        return $file;
    }

    public function makeCourse(string $CourseName, string $CoursePath): bool|object
    {
        $getCourse = Course::where("course_name", $CourseName)->where('course_path', $CoursePath);
        if ($getCourse->count() != 0 ){
            return false;
        }
        if (!Storage::exists("laravel-downloader/" . $CoursePath)){
            Storage::makeDirectory("laravel-downloader/" . $CoursePath);
        }
        return Course::create([
            "course_name" =>$CourseName,
            'course_path' => $CoursePath
        ]);
    }

    public function getDurationCourse(int $Course_ID): string|bool
    {
        $getID3 = new \getID3;
        $DI = 0;
        $coures = Course::where('id', $Course_ID);
        if ($coures->count() != 1){
            return false;
        }
        foreach (Storage::files("laravel-downloader/" . $coures->get()[0]->course_path) as $FilePath){
            $mimes = [
                "WEBM",
                "AVI",
                "MP4"
            ];
            if (array_search(strtoupper(pathinfo(basename(Storage::path($FilePath)), PATHINFO_EXTENSION)), $mimes)){
                $file = $getID3->analyze(Storage::path($FilePath));

                $DI = $DI + $file['playtime_seconds'];
            }
        }
        $duration = gmdate('H:i:s', $DI);
        $coures->update([
            "duration" =>  $duration
        ]);
        return $duration;
    }
}
