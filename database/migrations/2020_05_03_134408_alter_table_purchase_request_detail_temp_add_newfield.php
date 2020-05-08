<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePurchaseRequestDetailTempAddNewfield extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_request_detail_temps', function (Blueprint $table) {
            $table->integer('is_validate')->default(0);
            $table->integer('is_material')->default(0);
            $table->integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_request_detail_temps', function (Blueprint $table) {
            $table->dropColumn('is_validate')->default(0);
            $table->dropColumn('is_material')->default(0);
            $table->dropColumn('status')->default(0);
        });
    }
}
