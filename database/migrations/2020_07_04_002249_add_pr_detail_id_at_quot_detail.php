<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrDetailIdAtQuotDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation_details', function (Blueprint $table) {
            $table->string('request_detail_id')->nullable();
        });

        Schema::table('purchase_orders_details', function (Blueprint $table) {
            $table->string('request_detail_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotation_details', function (Blueprint $table) {
            //
        });
    }
}
