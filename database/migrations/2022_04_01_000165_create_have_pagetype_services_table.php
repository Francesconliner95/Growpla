<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHavePagetypeServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('have_pagetype_services', function (Blueprint $table) {
            //$table->id();
            $table->unsignedbigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->unsignedbigInteger('pagetype_id');
            $table->foreign('pagetype_id')->references('id')->on('pagetypes')->onDelete('cascade');

            $table->unique(['service_id', 'pagetype_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('have_pagetype_services');
    }
}
