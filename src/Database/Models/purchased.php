<?php

namespace DevNullIr\LaravelDownloader\Database\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class purchased extends BaseModel
{
    use HasFactory;
    protected $table = "purchased";
    protected $fillable = [
        'file_id',
        'user_id',
        'count'
    ];
}
