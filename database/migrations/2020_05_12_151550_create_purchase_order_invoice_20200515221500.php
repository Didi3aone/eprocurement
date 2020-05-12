<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderInvoice20200515221500 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_invoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('purchase_order_id')->index();
            $table->integer('request_id')->index();
            $table->string('payment_terms')->nullable();
            $table->string('payment_in_days_1')->nullable();
            $table->string('payment_in_percent_1')->nullable();
            $table->string('payment_in_days_2')->nullable();
            $table->string('payment_in_percent_2')->nullable();
            $table->string('payment_in_days_3')->nullable();
            $table->string('payment_in_percent_3')->nullable();
            $table->string('currency')->nullable();
            $table->string('exchange_rate')->nullable();
            $table->string('sales_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('language')->nullable();
            $table->string('your_reference')->nullable();
            $table->string('our_reference')->nullable();
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
        Schema::dropIfExists('purchase_order_invoice');
    }
}
