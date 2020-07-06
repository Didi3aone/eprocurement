<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPoGrAddCostCenter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_gr', function (Blueprint $table) {
            $table->string('cost_center_code')->nullable();
        });

        Schema::table('billing_details', function (Blueprint $table) {
            $table->string('cost_center_code')->nullable();
        });

        Schema::table('master_bank_house', function (Blueprint $table) {
            $table->string('house_bank')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_order_gr', function (Blueprint $table) {
            //
        });
    }
}
