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
            $table->decimal('latitude')->nullable();
            $table->decimal('longitude')->nullable();
            //STURTUP
            $table->tinyInteger('lifecycle_id')->nullable();
            $table->string('pitch')->nullable();
            $table->boolean('incorporated')->nullable();

            $table->tinyInteger('moneyrange_id')->nullable();
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
