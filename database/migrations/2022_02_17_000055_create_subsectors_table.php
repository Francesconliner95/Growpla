<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubsectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subsectors', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('sector_id');
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade');
            $table->string('subsector_name');
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
        Schema::dropIfExists('subsectors');
    }
}
