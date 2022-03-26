<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedbigInteger('notification_type_id')->default(0);
            $table->foreign('notification_type_id')->references('id')->on('notification_types')->onDelete('cascade');
            $table->unsignedbigInteger('ref_user_id')->nullable();
            $table->foreign('ref_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedbigInteger('ref_page_id')->nullable();
            $table->foreign('ref_page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->unsignedbigInteger('ref_to_user_id')->nullable();
            $table->foreign('ref_to_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedbigInteger('ref_to_page_id')->nullable();
            $table->foreign('ref_to_page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->unsignedbigInteger('usertype_id')->nullable();
            $table->foreign('usertype_id')->references('id')->on('usertypes')->onDelete('cascade');
            $table->unsignedbigInteger('pagetype_id')->nullable();
            $table->foreign('pagetype_id')->references('id')->on('pagetypes')->onDelete('cascade');
            $table->string('parameter');
            $table->boolean('read')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
