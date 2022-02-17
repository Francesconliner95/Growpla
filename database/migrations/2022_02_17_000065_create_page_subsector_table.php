<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageSubsectorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_subsector', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->unsignedbigInteger('subsector_id');
            $table->foreign('subsector_id')->references('id')->on('subsectors')->onDelete('cascade');

            $table->unique(['page_id', 'subsector_id']);

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
        Schema::dropIfExists('page_subsector');
    }
}
