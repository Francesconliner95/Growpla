<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicTtagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_ttag', function (Blueprint $table) {
            $table->unsignedbigInteger('topic_id')->nullable();
            // $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
            $table->foreign('topic_id')->references('id')->on('topics');

            $table->unsignedbigInteger('ttag_id')->nullable();
            // $table->foreign('t_tag_id')->references('id')->on('t_tags')->onDelete('cascade');
            $table->foreign('ttag_id')->references('id')->on('ttags');

            $table->primary(['topic_id', 'ttag_id']);
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
        Schema::dropIfExists('topic_ttag');
    }
}
