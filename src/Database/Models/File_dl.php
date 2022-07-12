<?php

namespace DevNullIr\LaravelDownloader\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class File_dl extends BaseModel
{
    use HasFactory;
    protected $table = "files_dl";
    protected $fillable = [
        'path'
    ];
}
