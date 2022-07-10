<?php

namespace DevNullIr\LaravelDownloader\Database\Models;

class File_dl extends BaseModel
{
    protected $table = "files_dl";
    protected $fillable = [
        'path'
    ];
}
