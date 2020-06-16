<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPoDetailAddFewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_orders_details', function (Blueprint $table) {
            $table->string('material_id')->nullable();
            $table->integer('is_assets')->default(0);
            $table->string('assets_no')->nullable();
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
            $table->string('material_group',20)->nullable();
            $table->string('preq_item',20)->nullable();
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
