<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMasterAcpMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_acp_materials', function (Blueprint $table) {
            $table->string('file_attachment')->nullable();
        });

        Schema::table('master_acps', function (Blueprint $table) {
            $table->renameColumn('is_approval','status_approval')->nullable();
        });

        Schema::table('quotation_approvals', function (Blueprint $table) {
            $table->integer('acp_id')->default(0);
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
            
        });
    }
}
