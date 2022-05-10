<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBackgroundsTable extends Migration
{

    public function up()
    {
        Schema::create('user_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedbigInteger('background_id');
            $table->foreign('background_id')->references('id')->on('backgrounds')->onDelete('cascade');
            $table->unique(['user_id', 'background_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_backgrounds');
    }
}
