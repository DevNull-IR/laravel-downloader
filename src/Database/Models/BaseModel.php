<?php

namespace DevNullIr\LaravelDownloader\Database\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class BaseModel extends Model
{
    public function Test(): string
    {
        return "LaravelDownloader";
    }
}
