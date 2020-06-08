<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRfqsDetailsChangePercent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rfqs_details', function (Blueprint $table) {
            $table->string('purchasing_document')->change();
            $table->string('vendor')->change();
            $table->string('payment_terms')->change();
            $table->renameColumn('disc_persent1', 'disc_percent1');
            $table->renameColumn('disc_persent2', 'disc_percent2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rfqs_details', function (Blueprint $table) {
            $table->renameColumn('disc_percent1', 'disc_persent1');
            $table->renameColumn('disc_percent2', 'disc_persent2');
        });
    }
}
