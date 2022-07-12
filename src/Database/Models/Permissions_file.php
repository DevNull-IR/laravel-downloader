<?php

namespace DevNullIr\LaravelDownloader\Database\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permissions_file extends BaseModel
{
    use HasFactory;
    protected $table = "permissions_file";
    protected $fillable = [
        'purchased_id',
        'token',
        'time'
    ];
}
