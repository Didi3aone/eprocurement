<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterQuotationAddShipId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation', function (Blueprint $table) {
            $table->integer('ship_id')->nullable();
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->integer('ship_id')->nullable();
        });

        Schema::table('purchase_order_gr', function (Blueprint $table) {
            $table->string('description')->nullable();
        });

        Schema::table('billing_details', function (Blueprint $table) {
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotation', function (Blueprint $table) {
            //
        });
    }
}
