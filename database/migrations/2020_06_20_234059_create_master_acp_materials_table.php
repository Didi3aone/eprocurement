<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterAcpMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_acp_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('master_acp_id');
            $table->bigInteger('master_acp_vendor_id');
            $table->string('material_id');
            $table->string('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_acp_materials');
    }
}
