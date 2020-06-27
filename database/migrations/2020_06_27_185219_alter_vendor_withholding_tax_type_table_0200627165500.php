<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVendorWithholdingTaxTypeTable0200627165500 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_withholding_tax_type', function (Blueprint $table) {
            $table->string('subject')->default('X')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_withholding_tax_type', function (Blueprint $table) {
            $table->dropColumn('subject');
        });
    }
}
