<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPoDetailAdded extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('purchase_orders_details', function (Blueprint $table) {
        //     // $table->bigInteger('rfq_number')->nullable();
        //     $table->date('delivery_date_old')->nullable();
        //     $table->decimal('qty_old')->default('0.00');
        // });

        // Schema::table('quotation_details', function (Blueprint $table) {
        //     $table->bigInteger('rfq_number')->nullable();
        // });

        // Schema::table('rfq_details', function (Blueprint $table) {
        //     $table->string('currency')->nullable();
        // });

        // Schema::table('billings', function (Blueprint $table) {
        //     $table->decimal('dpp',16,2)->default('0.00')->change();
        // });

        // Schema::table('rfqs', function (Blueprint $table) {
        //     $table->dropColumn('po_number');
        // });

        // Schema::table('rfq_details', function (Blueprint $table) {
        //     $table->string('po_number')->nullable();
        //     $table->string('vendor_id')->nullable();
        // });

        // Schema::table('purchase_order_change_history_detail', function (Blueprint $table) {
        //     $table->date('delivery_date_old')->nullable();
        //     $table->date('delivery_date_change')->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_order_details', function (Blueprint $table) {
            //
        });
    }
}
