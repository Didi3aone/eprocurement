<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFieldPoDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_orders_details', function (Blueprint $table) {
            $table->dropColumn('is_assets');
            $table->dropColumn('short_text');
            $table->dropColumn('text_id');
            $table->dropColumn('text_form');
            $table->dropColumn('delivery_date_category');
            $table->dropColumn('preq_name');
            $table->dropColumn('account_assignment');
            $table->dropColumn('purchasing_group_code');
            $table->dropColumn('gl_acct_code');
            $table->dropColumn('cost_center_code');
            $table->dropColumn('profit_center_code');
            $table->dropColumn('storage_location');
            $table->dropColumn('plant_code');
            $table->dropColumn('text_line');
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
