<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderChangeHistoryDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_change_history_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('po_history_id');
            $table->integer('po_detail_id');
            $table->decimal('qty_old',16,2)->default('0.00');
            $table->decimal('qty_change',16,2)->default('0.00');
            $table->decimal('price_old',16,2)->default('0.00');
            $table->decimal('price_change',16,2)->default('0.00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_change_history_detail');
    }
}
