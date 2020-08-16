<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddedNewField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation_details', function (Blueprint $table) {
            $table->bigInteger('is_free_item')->default(0);
        });

        Schema::table('purchase_orders_details', function (Blueprint $table) {
            $table->bigInteger('is_free_item')->default(0);
        });

        Schema::table('master_acps', function (Blueprint $table) {
            $table->decimal('exchange_rate',16,2)->default(0.00);
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
