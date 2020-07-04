<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterPphTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_pph', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('country_key')->nullable();
            $table->string('withholding_tax_type')->nullable();
            $table->string('withholding_tax_code')->nullable();
            $table->string('withholding_tax_rate')->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('master_pph');
    }
}
