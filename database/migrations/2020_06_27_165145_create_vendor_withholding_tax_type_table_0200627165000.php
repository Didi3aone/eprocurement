<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorWithholdingTaxTypeTable0200627165000 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_withholding_tax_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vendor_id')->index(); 
            $table->string('company_code')->nullable();
            $table->string('withholding_tax_type')->nullable();
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
        Schema::dropIfExists('vendor_withholding_tax_type');
    }
}
