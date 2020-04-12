<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterQuotationsRemoveAndAddSomeFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation', function (Blueprint $table) {
            $table->dropColumn('po_date');
            $table->string('upload_file')->nullable();
            $table->string('leadtime_type')->default(0);
            $table->string('purchasing_leadtime')->nullable();
            $table->string('vendor_leadtime')->nullable();
            $table->integer('target_price')->nullable();
            $table->integer('vendor_price')->nullable();
            $table->date('expired_date')->nullable();
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
            $table->date('po_date')->nullable();
            $table->dropColumn('upload_file');
            $table->dropColumn('leadtime_type');
            $table->dropColumn('purchasing_leadtime');
            $table->dropColumn('vendor_leadtime');
            $table->dropColumn('target_price');
            $table->dropColumn('vendor_price');
            $table->dropColumn('expired_date');
        });
    }
}
