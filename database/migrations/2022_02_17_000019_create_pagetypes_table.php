<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagetypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagetypes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_it')->nullable();
            $table->text('description')->nullable();
            $table->text('description_it')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('pagetypes');
    }
}
