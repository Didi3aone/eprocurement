<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMasterAcpMaterialsV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_acp_materials', function (Blueprint $table) {
            // $table->string('unit')->nullable();
            $table->decimal('qty_pr',16,2)->default('0.00');
            $table->decimal('total_price',16,2)->default('0.00');
            // $table->string('purchasing_group_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_acp_materials', function (Blueprint $table) {
            //
        });
    }
}
