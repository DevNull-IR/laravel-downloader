<?php

namespace DevNullIr\LaravelDownloader\Http\Controllers;

use DevNullIr\LaravelDownloader\Database\Models\File_dl;
use DevNullIr\LaravelDownloader\Database\Models\Permissions_file;
use DevNullIr\LaravelDownloader\Database\Models\purchased;
use DevNullIr\LaravelDownloader\Facade\LaravelDownloaderFacade;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DownloaderController extends BaseController
{
    public function dl(string $DownloadToekn)
    {
        return $this->download($DownloadToekn);
    }

    public function thank_dl(string $DownloadToekn)
    {
        return view("LaravelDownloader::download", ['redirect' => route("laravelDownloaderDl", $DownloadToekn)]);
    }
    protected function download(string $DownloadToekn)
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

    public function Config()
    {
        $array = [];
        $array[] = LaravelDownloaderFacade::makeDirectory('public');
        $array[] = LaravelDownloaderFacade::makeDirectory('imgs');
        $array[] = LaravelDownloaderFacade::makeDirectory('fonts');
        $array[] = LaravelDownloaderFacade::makeDirectory('others');
        return $array;
    }
}
