<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFieldQuotaionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation_details', function (Blueprint $table) {
            $table->dropColumn('rfq_detail_id');
            $table->dropColumn('flag');
            $table->dropColumn('vendor_id');
            $table->dropColumn('vendor_leadtime');
            $table->dropColumn('vendor_price');
            $table->dropColumn('is_winner');
            $table->float('price')->nullable()->default(123.45)->change();
            // $table->double('price', 16, 2)->nullable()->default(123.45)->change();
        });

        Schema::table('quotation', function (Blueprint $table) {
            $table->dropColumn('leadtime_type');
            $table->dropColumn('purchasing_leadtime');
            $table->dropColumn('vendor_leadtime');
            $table->dropColumn('target_price');
            $table->dropColumn('vendor_price');
            $table->dropColumn('expired_date');
            $table->dropColumn('online');
            $table->dropColumn('is_winner');
            $table->dropColumn('qty');
            $table->dropColumn('acp_id');
            $table->dropColumn('start_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotation_details', function (Blueprint $table) {
            //
        });
    }
}
