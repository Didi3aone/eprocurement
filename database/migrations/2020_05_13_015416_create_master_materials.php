<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('description')->nullable();
            $table->string('plant_code')->nullable();
            $table->string('material_type_code')->nullable();
            $table->string('uom_code')->nullable();
            $table->string('purchasing_group_code')->nullable();
            $table->string('storage_location_code')->nullable();
            $table->string('material_group_code')->nullable();
            $table->string('profit_center_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_materials');
    }
}
