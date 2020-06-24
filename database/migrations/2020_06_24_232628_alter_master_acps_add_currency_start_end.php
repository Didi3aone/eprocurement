<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMasterAcpsAddCurrencyStartEnd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_acps', function (Blueprint $table) {
            $table->string('currency')->default('IDR')->comment('IDR, USD');
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_acps', function (Blueprint $table) {
            $table->dropColumn('currency');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
        });
    }
}
