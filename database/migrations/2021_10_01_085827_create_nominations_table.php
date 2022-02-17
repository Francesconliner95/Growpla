<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNominationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominations', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('cofounder_id');
            $table->foreign('cofounder_id')->references('id')->on('cofounders')->onDelete('cascade');
            $table->unsignedbigInteger('cofounder_account_id');
            $table->foreign('cofounder_account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('nominations');
    }
}
