<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPrHistoryAddFewField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_request_history', function (Blueprint $table) {
            $table->bigInteger('qty_po')->default(0);
            $table->bigInteger('qty_outstanding')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_request_history', function (Blueprint $table) {
            //
        });
    }
}
