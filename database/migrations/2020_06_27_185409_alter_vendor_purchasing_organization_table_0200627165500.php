<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVendorPurchasingOrganizationTable0200627165500 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_purchasing_organization', function (Blueprint $table) {
            $table->string('term_of_payment_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_purchasing_organization', function (Blueprint $table) {
            $table->dropColumn('term_of_payment_key');
        });
    }
}
