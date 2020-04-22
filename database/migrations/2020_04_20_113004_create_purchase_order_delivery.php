<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderDelivery extends Migration
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
            $table->bigInteger('po_id')->nullable();
            $table->string('terms')->nullable();
            $table->integer('first_in')->nullable();
            $table->integer('first_in_percentage')->nullable();
            $table->integer('second_in')->nullable();
            $table->integer('second_in_percentage')->nullable();
            $table->integer('third_in')->nullable();
            $table->string('currency')->nullable();
            $table->integer('exchange_rate')->nullable();
            $table->timestamps();
        });

        Schema::table('vendors', function (Blueprint $table) {
            $table->string('code')->nullable();
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

        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
}
