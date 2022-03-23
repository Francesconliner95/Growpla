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
            $table->unsignedbigInteger('page_selected_id')->nullable();//nessun collegamento
            $table->date('date_of_birth');
            $table->string('image')->nullable();
            $table->string('summary')->nullable();
            $table->text('description')->nullable();
            $table->string('cv')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('website')->nullable();
            $table->unsignedbigInteger('moneyrange_id')->nullable();
            $table->foreign('moneyrange_id')->references('id')->on('moneyranges');
            $table->unsignedbigInteger('currency_id')->default(1);
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->integer('startup_n')->nullable();
            $table->unsignedbigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->unsignedbigInteger('region_id')->nullable();
            $table->foreign('region_id')->references('id')->on('regions');
            $table->double('latitude', 10, 7)->nullable();
            $table->double('longitude', 10, 7)->nullable();
            $table->string('municipality')->nullable();
            $table->unsignedbigInteger('language_id')->default(1);
            $table->foreign('language_id')->references('id')->on('languages');
            $table->timestamp('last_access')->nullable();
            $table->tinyInteger('tutorial')->default(1)->nullable();
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
