<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRequestNotesAddIsValidate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_notes', function (Blueprint $table) {
            $table->tinyInteger('is_validate')->nullable();
        });
        Schema::table('request_notes_details', function (Blueprint $table) {
            $table->string('assets_no')->nullable();
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
            $table->dropColumn('is_validate');
        });
        Schema::table('request_notes_details', function (Blueprint $table) {
            $table->dropColumn('assets_no');
        });
    }
}
