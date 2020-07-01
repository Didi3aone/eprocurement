<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableGr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_gr', function (Blueprint $table) {
            $table->bigInteger('price_per_pc')->default(0);
        });

        Schema::table('quotation_details', function (Blueprint $table) {
            $table->bigInteger('item_category')->default(0);
            $table->bigInteger('package_no')->default(0);
            $table->bigInteger('subpackage_no')->default(0);
            $table->bigInteger('line_no')->default(0);
        });

        Schema::table('purchase_orders_details', function (Blueprint $table) {
            $table->bigInteger('item_category')->default(0);
            $table->string('PO_ITEM',20)->default(0);
            $table->bigInteger('package_no')->default(0);
            $table->bigInteger('subpackage_no')->default(0);
            $table->bigInteger('line_no')->default(0);
            $table->bigInteger('is_active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_order_gr', function (Blueprint $table) {
            //
        });
    }
}
