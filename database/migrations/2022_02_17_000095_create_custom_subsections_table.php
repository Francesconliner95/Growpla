<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomSubsectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_subsections', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('custom_section_id');
            $table->foreign('custom_section_id')->references('id')->on('custom_sections')->onDelete('cascade');
            $table->string('title');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->smallInteger('position')->default(0);
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
        Schema::dropIfExists('custom_subsections');
    }
}
