<?php

namespace DevNullIr\LaravelDownloader\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends BaseModel
{
    use HasFactory;
    protected $table = "courses_dl";
    protected $fillable = [
        'course_path',
        'duration',
        'course_name'
    ];
}
