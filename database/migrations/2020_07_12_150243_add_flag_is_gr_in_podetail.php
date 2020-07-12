<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlagIsGrInPodetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_orders_details', function (Blueprint $table) {
            $table->integer('is_gr')->default(0);
        });

        Schema::table('purchase_order_gr', function (Blueprint $table) {
            $table->integer('is_send_email')->default(0);
        });
        Schema::table('quotation', function (Blueprint $table) {
            $table->date('approved_date_ass')->nullable();
            $table->date('approved_date_head')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_orders_details', function (Blueprint $table) {
            //
        });
    }
}
