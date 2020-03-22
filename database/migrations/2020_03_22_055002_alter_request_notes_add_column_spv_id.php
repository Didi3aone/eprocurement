<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRequestNotesAddColumnSpvId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_notes', function (Blueprint $table) {
            $table->string('spv_id',10)->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_notes', function (Blueprint $table) {
            $table->dropColumn('spv_id',10)->unsigned()->nullable();
        });
    }
}
