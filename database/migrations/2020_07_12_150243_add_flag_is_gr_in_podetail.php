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

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->string('approved_asspro')->nullable();
            $table->string('approved_head')->nullable();
        });

        Schema::table('vendors', function (Blueprint $table) {
            $table->string('swift_code')->nullable();
            $table->integer('is_export')->default(0);
            $table->integer('is_approve_proc')->default(0);
        });

        Schema::table('master_acp_materials', function (Blueprint $table) {
            $table->decimal('price',16,2);
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
