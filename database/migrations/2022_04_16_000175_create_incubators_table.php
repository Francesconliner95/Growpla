<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncubatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incubators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->default('pages_images/default-incubatore.svg');
            $table->string('website')->nullable();
            $table->unsignedbigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedbigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->unsignedbigInteger('page_id')->nullable();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
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
        Schema::dropIfExists('incubators');
    }
}
