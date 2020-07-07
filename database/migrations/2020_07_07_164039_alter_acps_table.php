<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAcpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_acps', function (Blueprint $table) {
            $table->string('reason_reject')->nullable();
        });

        Schema::table('quotation_approvals', function (Blueprint $table) {
            $table->string('reason_reject')->nullable();
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
            //
        });
    }
}
