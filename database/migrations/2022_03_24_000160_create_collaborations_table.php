<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollaborationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaborations', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('col1_user_id')->nullable();
            $table->foreign('col1_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedbigInteger('col1_page_id')->nullable();
            $table->foreign('col1_page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->unsignedbigInteger('col2_user_id')->nullable();
            $table->foreign('col2_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedbigInteger('col2_page_id')->nullable();
            $table->foreign('col2_page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->tinyInteger('col1_confirmed')->nullable();
            $table->tinyInteger('col2_confirmed')->nullable();
            $table->tinyInteger('col1_show')->nullable()->default(1);
            $table->tinyInteger('col2_show')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collaborations');
    }
}
