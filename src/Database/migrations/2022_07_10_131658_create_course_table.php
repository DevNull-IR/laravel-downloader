<?php

namespace DevNullIr\LaravelDownloader\Database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends BaseMigration{

    public function up()
    {
        Schema::create('courses_dl', function (Blueprint $table){
            $table->id();
            $table->text('course_path');
            $table->text('course_name');
            $table->string("duration")->nullable();
            $table->unique([
                'course_path',
                'course_name'
            ]);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('courses_dl');
    }

};
