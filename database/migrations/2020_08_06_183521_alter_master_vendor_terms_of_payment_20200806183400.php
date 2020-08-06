<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMasterVendorTermsOfPayment20200806183400 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_vendor_terms_of_payment', function (Blueprint $table) {
            $table->integer('number_of_days')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_vendor_terms_of_payment', function (Blueprint $table) {
            $table->dropColumn('number_of_days');
        });
    }
}
