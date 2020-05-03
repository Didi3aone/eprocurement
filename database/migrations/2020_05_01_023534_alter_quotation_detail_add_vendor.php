<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterQuotationDetailAddVendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation_details', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('qty');
            $table->dropColumn('unit');
            $table->dropColumn('notes');
            $table->dropColumn('price');
            $table->integer('vendor_id')->nullable();
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
            $table->string('description')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('unit')->nullable();
            $table->string('notes')->nullable();
            $table->integer('price')->nullable();
            $table->dropColumn('vendor_id');
        });
    }
}
