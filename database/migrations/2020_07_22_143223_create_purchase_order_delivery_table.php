<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_delivery', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('purchase_order_id');
            $table->integer('purchase_order_detail_id')->nullable();
            $table->string('sched_line')->nullable();
            $table->string('po_item')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('preq_no')->nullable();
            $table->string('preq_item')->nullable();
            $table->decimal('qty',16,2)->default('0.00');
            $table->timestamps();
        });

        Schema::table('quotation_deliverys', function (Blueprint $table) {
            $table->string('PO_ITEM')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_delivery');
    }
}
