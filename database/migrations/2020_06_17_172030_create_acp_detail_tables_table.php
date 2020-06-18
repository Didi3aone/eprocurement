<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcpDetailTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acp_detail_tables', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->bigInteger('material_id');
            $table->bigInteger('harga')->default(0);
            $table->bigInteger('vendor_code')->default(0);
            $table->bigInteger('win_rate')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acp_detail_tables');
    }
}
