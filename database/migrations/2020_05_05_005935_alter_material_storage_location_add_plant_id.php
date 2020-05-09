<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMaterialStorageLocationAddPlantId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_storage_location', function (Blueprint $table) {
            $table->bigInteger('plant_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('material_storage_location', function (Blueprint $table) {
            $table->dropColumn('plant_id')->nullable();
        });
    }
}
