<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogImagesTable extends Migration
{

    public function up()
    {
        Schema::create('blog_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('blog_id');
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            $table->string('path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_images');
    }
}
