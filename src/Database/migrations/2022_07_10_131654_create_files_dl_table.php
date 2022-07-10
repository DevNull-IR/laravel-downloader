<?php

namespace DevNullIr\LaravelDownloader\Database\migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends BaseMigration{

    public function up()
    {
        Schema::create('files_dl', function (Blueprint $table){
            $table->id();
            $table->text('path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('files_dl');
    }

};
