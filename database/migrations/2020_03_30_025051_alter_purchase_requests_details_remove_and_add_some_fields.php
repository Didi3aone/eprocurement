<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPurchaseRequestsDetailsRemoveAndAddSomeFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requests_details', function (Blueprint $table) {
            $table->string('purchasing_group_code')->nullable();
            $table->string('preq_name')->nullable();
            $table->string('plant_code')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('gl_acct_code')->nullable();
            $table->string('cost_center_code')->nullable();
            $table->string('co_area')->nullable()->default('EGCA');
            $table->string('profit_center_code')->nullable();
            $table->string('func_area')->nullable();
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
            $table->dropColumn('purchasing_group_code');
            $table->dropColumn('preq_name');
            $table->dropColumn('plant_code');
            $table->dropColumn('serial_no');
            $table->dropColumn('gl_acct_code');
            $table->dropColumn('cost_center_code');
            $table->dropColumn('co_area');
            $table->dropColumn('profit_center_code');
            $table->dropColumn('func_area');
        });
    }
}
