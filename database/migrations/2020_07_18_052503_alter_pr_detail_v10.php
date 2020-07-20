<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPrDetailV10 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requests_details', function (Blueprint $table) {
            $table->integer('is_assets_prod')->nullable();
        });
        Schema::table('billings', function (Blueprint $table) {
            $table->dateTime('submitted_date',0)->nullable();
        });
        Schema::table('purchase_order_gr', function (Blueprint $table) {
            $table->integer('item_category')->default(0);
        });

        Schema::table('billing_details', function (Blueprint $table) {
            $table->integer('item_category')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_requests_details', function (Blueprint $table) {
            //
        });
    }
}
