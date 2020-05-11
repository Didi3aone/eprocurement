<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnInRequestNoteDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_notes_details', function (Blueprint $table) {
            $table->renameColumn('plant_code', 'material_group');
            $table->renameColumn('is_validate', 'storage_location');
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
            $table->renameColumn('plant_code', 'material_group');
            $table->renameColumn('is_validate', 'storage_location');
        });
    }
}
