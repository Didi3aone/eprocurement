<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnUserMapsFieldPlant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_maps', function (Blueprint $table) {
            $table->renameColumn('plant', 'purchasing_group_code');
            $table->renameColumn('nik', 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_maps', function (Blueprint $table) {
            //
        });
    }
}
