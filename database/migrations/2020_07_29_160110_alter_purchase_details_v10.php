<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPurchaseDetailsV10 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requests_details', function (Blueprint $table) {
            $table->bigInteger('deliv_plan_processing_time')->default(0);
            $table->bigInteger('gr_processing_time')->default(0);
            $table->decimal('qty_requested',16,2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
