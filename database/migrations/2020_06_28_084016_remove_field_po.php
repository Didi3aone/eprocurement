<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFieldPo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn('po_no');
            $table->dropColumn('bidding');
            $table->dropColumn('type');
            $table->dropColumn('condition_net');
            $table->dropColumn('condition_net_currency');
            $table->renameColumn('request_id','quotation_id');
        });

        Schema::table('purchase_orders_details', function (Blueprint $table) {
            $table->dropColumn('rfq_detail_id');
            $table->bigInteger('PR_NO')->default(0);
            $table->bigInteger('qty_gr')->default(0);
            $table->bigInteger('qty_outstanding')->default(0);
        });

        Schema::table('purchase_order_gr', function (Blueprint $table) {
            $table->bigInteger('purchase_order_detail_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            //
        });
    }
}
