<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterQuotationDetailAddVendorPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation_details', function (Blueprint $table) {
            $table->date('vendor_leadtime')->nullable();
            $table->integer('vendor_price')->nullable();
            $table->string('upload_file')->nullable();
            $table->string('notes')->nullable();
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
            $table->dropColumn('vendor_leadtime');
            $table->dropColumn('vendor_price');
            $table->dropColumn('upload_file');
            $table->dropColumn('notes');
        });
    }
}
