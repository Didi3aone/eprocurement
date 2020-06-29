<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('currency',10);
            $table->string('iso_code',10)->nullable();
            $table->bigInteger('alternative_key')->default(0);
            $table->string('valid_until')->default(0);
            $table->string('primary_sap_code')->default(0);
            $table->string('long_text')->default(0);
            $table->string('short_text')->default(0);
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
        Schema::dropIfExists('currency');
    }
}
