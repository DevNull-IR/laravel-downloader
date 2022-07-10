<?php

namespace DevNullIr\LaravelDownloader\Database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends BaseMigration{

    public function up()
    {
        Schema::create('purchased', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')
                ->references('id')
                ->on('files_dl')
                ->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->default(0);
            $table->integer('count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Purchased');
    }

};
