<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterBankHouse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_bank_house', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plant_cde');
            $table->bigInteger('house_bank');
            $table->string('bank_country');
            $table->string('bank_key');
            $table->string('contact_person');
            $table->string('description');
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
        Schema::dropIfExists('master_bank_house');
    }
}
