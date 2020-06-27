<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeColumnQuotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation', function (Blueprint $table) {
            $table->string('approved_asspro',50)->change();
            $table->string('approved_head',50)->change();
        });

        Schema::table('quotation_details', function (Blueprint $table) {
            $table->string('PO_ITEM')->change();
            $table->string('PREQ_ITEM')->default(0);
        });

        Schema::table('quotation_deliverys', function (Blueprint $table) {
            $table->string('PREQ_ITEM')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotation', function (Blueprint $table) {
            //
        });
    }
}
