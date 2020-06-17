<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPurchaseRequestaddedFlags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->integer('flags')->default(0);
            $table->integer('is_approve_procurement')->default(0);
            $table->string('approved_proc_by',10)->nullable();
            $table->string('validate_by',10)->nullable();
            $table->integer('plant_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            //
        });
    }
}
