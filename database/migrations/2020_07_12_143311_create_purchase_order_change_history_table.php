<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderChangeHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_change_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('po_id')->nullable();
            $table->string('vendor_old')->nullable();
            $table->string('vendor_change')->nullable();
            $table->string('notes_old')->nullable();
            $table->string('notes_change')->nullable();
            $table->string('payment_term_old')->nullable();
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
        Schema::dropIfExists('purchase_order_change_history');
    }
}
