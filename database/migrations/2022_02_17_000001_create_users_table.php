<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('name');
            $table->string('surname');
            $table->date('date_of_birth');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('cv')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('website')->nullable();
            $table->tinyInteger('moneyrange_id')->nullable();
            $table->tinyInteger('startup_n')->nullable();
            $table->decimal('latitude')->nullable();
            $table->decimal('longitude')->nullable();
            $table->smallInteger('language_id')->default(1);
            $table->timestamp('last_access')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
