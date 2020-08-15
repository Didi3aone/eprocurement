<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPoGrAddflag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_gr', function (Blueprint $table) {
            $table->integer('is_cancel')->default(1);
        });

        Schema::table('purchase_orders_details', function (Blueprint $table) {
            $table->integer('is_approve')->default(1);
            $table->decimal('qty_billing',16,2)->default('0.00');
        });

        Schema::table('billing_details', function (Blueprint $table) {
            $table->integer('purchase_order_detail_id')->nullable();
            $table->decimal('qty_billing',16,2)->default('0.00');
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
