<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChageTypeVendorsCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation', function (Blueprint $table) {
            $table->string('vendor_id')->change();
        });

        // Schema::table('purchase_orders_details', function (Blueprint $table) {
        //     $table->string('SCHED_LINE')->default(0);
        // });

        Schema::table('quotation_deliverys', function (Blueprint $table) {
            $table->string('SCHED_LINE')->change();
        });

        Schema::table('master_acp_vendors', function (Blueprint $table) {
            $table->string('vendor_code')->change();
        });

        Schema::table('master_acp_materials', function (Blueprint $table) {
            $table->string('master_acp_vendor_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            //
        });
    }
}
