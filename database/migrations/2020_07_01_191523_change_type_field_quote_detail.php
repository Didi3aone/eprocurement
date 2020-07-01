<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeFieldQuoteDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation_deliverys', function (Blueprint $table) {
            $table->integer('quotation_detail_id')->default(0);
        });
        Schema::table('quotation_details', function (Blueprint $table) {
            $table->decimal('orginal_price', 16, 2)->change()->default(0.00);
            $table->decimal('price', 16, 2)->change()->default(0.00);
        });

        Schema::table('purchase_orders_details', function (Blueprint $table) {
            $table->decimal('original_price', 16, 2)->change()->default(0.00);
            $table->decimal('price', 16, 2)->change()->default(0.00);
            $table->date('delivery_date')->nullable();
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
