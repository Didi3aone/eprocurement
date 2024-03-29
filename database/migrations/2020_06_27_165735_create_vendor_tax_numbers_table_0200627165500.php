<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorTaxNumbersTable0200627165500 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_tax_numbers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vendor_id')->index(); 
            $table->string('tax_numbers_category')->nullable();
            $table->string('tax_numbers')->nullable();
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
        Schema::dropIfExists('vendor_tax_numbers');
    }
}
