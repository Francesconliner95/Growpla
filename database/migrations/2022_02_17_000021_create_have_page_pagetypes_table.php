<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHavePagePagetypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('have_page_pagetypes', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('page_id');
            $table->foreign('page_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedbigInteger('pagetype_id');
            $table->foreign('pagetype_id')->references('id')->on('pagetypes')->onDelete('cascade');

            $table->unique(['page_id', 'pagetype_id']);

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
        Schema::dropIfExists('have_page_pagetypes');
    }
}
