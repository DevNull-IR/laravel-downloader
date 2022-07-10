<?php

namespace DevNullIr\LaravelDownloader\Database\Models;

class Permissions_file extends BaseModel
{
    protected $table = "permissions_file";
    protected $fillable = [
        'purchased_id',
        'token',
        'time'
    ];
}
