<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAllTypeQty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requests_details', function (Blueprint $table) {
            $table->decimal('qty', 16, 2)->change()->default(0.00);
            $table->decimal('qty_order', 16, 2)->change()->default(0.00);
        });

        Schema::table('quotation_details', function (Blueprint $table) {
            $table->decimal('qty', 16, 2)->change()->default(0.00);
        });

        Schema::table('purchase_orders_details', function (Blueprint $table) {
            $table->decimal('qty', 16, 2)->change()->default(0.00);
            $table->decimal('qty_gr', 16, 2)->change()->default(0.00);
            $table->decimal('qty_outstanding', 16, 2)->change()->default(0.00);
        });

        Schema::table('quotation_deliverys', function (Blueprint $table) {
            $table->decimal('QUANTITY', 16, 2)->change()->default(0.00);
        });

        Schema::table('master_acp_materials', function (Blueprint $table) {
            $table->decimal('qty', 16, 2)->change()->default(0.00);
        });

        Schema::table('purchase_request_history', function (Blueprint $table) {
            $table->decimal('qty', 16, 2)->change()->default(0.00);
            $table->decimal('qty_po', 16, 2)->change()->default(0.00);
            $table->decimal('qty_outstanding', 16, 2)->change()->default(0.00);
        });

        Schema::table('purchase_order_gr', function (Blueprint $table) {
            $table->decimal('qty', 16, 2)->change()->default(0.00);
            $table->decimal('price_per_pc', 16, 2)->change()->default(0.00);
        });

        Schema::table('request_notes_details', function (Blueprint $table) {
            $table->decimal('qty', 16, 2)->change()->default(0.00);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_request_details', function (Blueprint $table) {
            //
        });
    }
}
