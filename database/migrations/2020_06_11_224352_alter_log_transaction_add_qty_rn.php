<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLogTransactionAddQtyRn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_gi_transactions', function (Blueprint $table) {
            $table->string('qty_rn',5)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_gi_transactions', function (Blueprint $table) {
            $table->string('qty_rn',5)->default(0);
        });
    }
}
