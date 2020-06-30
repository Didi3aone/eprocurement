<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPoDetailsAdddedFewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_orders_details', function (Blueprint $table) {
            $table->integer('acp_id')->default(0);
            $table->string('short_text')->nullable();
            $table->string('text_id')->nullable();
            $table->string('text_form',10)->nullable();
            $table->string('text_line')->nullable();
            $table->string('delivery_date_category')->nullable();
            $table->string('account_assignment')->nullable();
            $table->string('purchasing_group_code',5)->nullable();
            $table->string('preq_name')->nullable();
            $table->string('gl_acct_code')->nullable();
            $table->string('cost_center_code',20)->nullable();
            $table->string('profit_center_code',20)->nullable();
            $table->string('storage_location',10)->nullable();
            $table->string('request_no',40)->nullable();
            $table->string('tax_code',4)->nullable();
            $table->bigInteger('original_price')->default(0);
            $table->string('currency')->default(0);
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->string('plant_code')->nullable();
        });

        Schema::table('quotation_details', function (Blueprint $table) {
            $table->string('tax_code')->nullable();
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
