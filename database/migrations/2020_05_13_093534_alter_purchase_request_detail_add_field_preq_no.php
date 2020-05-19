<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPurchaseRequestDetailAddFieldPreqNo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requests_details', function (Blueprint $table) {
            $table->string('preq_item',10)->nullable();
            $table->string('request_temp_detail_id')->nullable();
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
            $table->dropColumn('preq_item',10)->nullable();
            $table->dropColumn('request_temp_detail_id')->nullable();
        });
    }
}
