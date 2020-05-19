<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPurchaseTempsAddFlagSendSap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_request_temps', function (Blueprint $table) {
            $table->string('is_send_sap',5)->default('NO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_request_temps', function (Blueprint $table) {
            $table->dropColumn('is_send_sap',5)->default('NO');
        });
    }
}
