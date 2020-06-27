<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorPartnerFunctionsTable0200627165000 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_partner_functions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vendor_id')->index(); 
            $table->string('purchasing_organization')->nullable();
            $table->string('partner_functions')->nullable();
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
        Schema::dropIfExists('vendor_partner_functions');
    }
}
