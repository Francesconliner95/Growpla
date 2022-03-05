<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('pagetype_id');
            $table->foreign('pagetype_id')->references('id')->on('pagetypes');
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->tinyInteger('page_varificated')->nullable();
            $table->string('slug')->unique();
            $table->unsignedbigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->unsignedbigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('id')->on('regions');
            $table->double('latitude', 10, 7)->nullable();
            $table->double('longitude', 10, 7)->nullable();
            $table->string('street_name')->nullable();
            $table->string('street_number')->nullable();
            $table->string('municipality')->nullable();
            //STURTUP
            $table->unsignedbigInteger('lifecycle_id')->nullable();
            $table->foreign('lifecycle_id')->references('id')->on('lifecycles');
            $table->string('pitch')->nullable();
            $table->boolean('incorporated')->nullable();

            $table->unsignedbigInteger('moneyrange_id')->nullable();
            $table->foreign('moneyrange_id')->references('id')->on('moneyranges');
            $table->integer('startup_n')->nullable();

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
        Schema::dropIfExists('pages');
    }
}
