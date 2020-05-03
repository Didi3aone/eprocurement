<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVendorsAddSomeFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('specialize')->nullable();
            $table->string('company_name')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('code_area')->nullable();
            $table->string('pkp')->nullable();
            $table->string('office_phone')->nullable();
            $table->string('office_fax')->nullable();
            $table->string('phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('specialize');
            $table->dropColumn('company_name');
            $table->dropColumn('zip_code');
            $table->dropColumn('code_area');
            $table->dropColumn('pkp');
            $table->dropColumn('office_phone');
            $table->dropColumn('office_fax');
            $table->dropColumn('phone');
        });
    }
}
