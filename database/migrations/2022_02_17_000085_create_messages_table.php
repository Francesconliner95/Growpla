<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('chat_id');
            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');

            $table->unsignedbigInteger('sender_user_id')->nullable();
            $table->foreign('sender_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedbigInteger('sender_page_id')->nullable();
            $table->foreign('sender_page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->unsignedbigInteger('recipient_user_id')->nullable();
            $table->foreign('recipient_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedbigInteger('recipient_page_id')->nullable();
            $table->foreign('recipient_page_id')->references('id')->on('pages')->onDelete('cascade');

            $table->text('message');
            $table->boolean('readed')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
