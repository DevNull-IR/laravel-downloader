<?php

namespace DevNullIr\LaravelDownloader\Database\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class purchased extends BaseModel
{
    protected $table = "purchased";
    protected $fillable = [
        'file_id',
        'user_id',
        'count'
    ];
}
