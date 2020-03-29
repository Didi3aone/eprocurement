<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRequestsNotesDetailsAddColumnIsPr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_notes_details', function (Blueprint $table) {
            $table->integer('is_pr')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_notes_details', function (Blueprint $table) {
            $table->dropColumn('is_pr')->nullable()->default(0);
        });
    }
}
