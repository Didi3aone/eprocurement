<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPrDetailAddPackageNo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_request_detail_temps', function (Blueprint $table) {
            $table->string('package_no',30)->nullable();
            $table->string('subpackage_no',30)->nullable();
            $table->string('line_no',30)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_request_detail_temps', function (Blueprint $table) {
            $table->dropColumn('package_no',30)->nullable();
            $table->dropColumn('subpackage_no',30)->nullable();
            $table->dropColumn('line_no',30)->nullable();
        });
    }
}
