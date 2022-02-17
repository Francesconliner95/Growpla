<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedbigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->tinyInteger('account_type_id');
            $table->string('name', 40);
            $table->string('company', 50)->nullable();
            $table->string('image')->default('accounts_images/default_account_image.png');
            $table->string('cover_image')->default('accounts_cover_images/default_account_cover_image.jpg');
            $table->integer('sector_id')->nullable();
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('vat_number',30)->nullable();
            $table->bigInteger('money')->nullable();
            $table->smallInteger('currency_id')->default(1);
            $table->tinyInteger('account_varificated')->nullable();
            $table->string('slug')->unique();
            //STURTUP
            $table->tinyInteger('startup_status_id')->nullable();
            $table->date('incorporated')->nullable();
            $table->string('pitch')->nullable();
            $table->string('validation')->nullable();
            $table->string('roadmap')->nullable();
            //PRIVATE
            $table->boolean('investor')->nullable();
            $table->boolean('services')->nullable();
            $table->boolean('cofounder')->nullable();
            $table->tinyInteger('freelance_employee')->nullable();//sostituire con ba_associacion_id
            $table->string('role')->nullable();
            $table->string('curriculum_vitae')->nullable();
            //ACCELERATOR-INCUBATOR-INVESTOR-ENTI
            $table->integer('num_startup')->nullable();
            //BUSINESS ANGEL
            $table->tinyInteger('private_association')->default(1);
            //STARTUP-SERVICES
            $table->tinyInteger('startupservice_type_id')->nullable();
            //ENTE
            $table->tinyInteger('nation_region')->default(1);
            //INDIRIZZO
            $table->string('street')->nullable();
            $table->string('civic',10)->nullable();
            $table->string('city' ,50)->nullable();
            $table->smallInteger('region_id')->nullable();
            $table->smallInteger('state_id')->nullable();
            //CONTATTI
            $table->string('email')->nullable();
            $table->string('phone_number',15)->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
