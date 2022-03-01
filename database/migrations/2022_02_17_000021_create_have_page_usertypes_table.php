<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHavePageUsertypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('have_page_usertypes', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->unsignedbigInteger('usertype_id');
            $table->foreign('usertype_id')->references('id')->on('usertypes')->onDelete('cascade');

            $table->unique(['page_id', 'usertype_id']);

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
        Schema::dropIfExists('have_page_usertypes');
    }
}
