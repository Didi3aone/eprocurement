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
        Schema::table('purchase_orders_details', function (Blueprint $table) {
            // $table->bigInteger('rfq_number')->nullable();
            $table->date('delivery_date_old')->nullable();
            $table->decimal('qty_old')->default('0.00');
        });

        // Schema::table('quotation_details', function (Blueprint $table) {
        //     $table->bigInteger('rfq_number')->nullable();
        // });

        // Schema::table('rfq_details', function (Blueprint $table) {
        //     $table->string('currency')->nullable();
        // });

        // Schema::table('rfqs', function (Blueprint $table) {
        //     $table->integer('is_from_po')->default(1);
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
