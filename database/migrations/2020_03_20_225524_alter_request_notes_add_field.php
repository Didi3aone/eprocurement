<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRequestNotesAddField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_notes', function (Blueprint $table) {
            $table->integer('dept_id')->unsigned()->nullable();
            $table->integer('purchasing_group_id')->unsigned()->nullable();
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
            $table->dropColumn('dept_id')->unsigned()->nullable();
            $table->dropColumn('purchasing_group_id')->unsigned()->nullable();
        });
    }
}
