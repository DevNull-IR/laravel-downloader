<?php

namespace DevNullIr\LaravelDownloader\Database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends BaseMigration{

    public function up()
    {
        Schema::create('permissions_file', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('purchased_id');
            $table->foreign('purchased_id')
            ->references('id')
            ->on('purchased')
            ->onDelete('cascade');
            $table->text('token')->unique();
            $table->bigInteger('time');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('permissions_file');
    }

};
