<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('purchase_order_id')->unsigned();
            $table->string('description');
            $table->bigInteger('qty');
            $table->string('unit');
            $table->string('notes');
            $table->bigInteger('price');
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
        Schema::dropIfExists('purchase_orders_details');
    }
}
