<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_it')->nullable();
            $table->string('description')->nullable();
            $table->string('description_it')->nullable();
            //page_id riferimento per fare uscire i servizi startup nel ciclo di vita
            $table->unsignedbigInteger('pagetype_id')->nullable();
            $table->foreign('pagetype_id')->references('id')->on('pagetypes');
            $table->boolean('hidden')->nullable();
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
        Schema::dropIfExists('services');
    }
}
