<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterAcpVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_acp_vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('master_acp_id');
            $table->bigInteger('vendor_code');
            $table->integer('is_winner')->default(0);
            $table->integer('win_rate')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_acp_vendors');
    }
}
