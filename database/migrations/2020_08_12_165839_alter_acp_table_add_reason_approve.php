<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAcpTableAddReasonApprove extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_acps', function (Blueprint $table) {
            // $table->renameColumn('reason_approved','reason_approved_assproc');
            $table->longText('reason_approved_assproc')->nullable();
            $table->longText('reason_approved_head')->nullable();
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
