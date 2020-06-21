<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterAcpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_acps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('acp_no');
            $table->timestamps();
            $table->string('created_by');
            $table->string('updated_by');
            $table->softDeletes();
            $table->string('deleted_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_acp');
    }
}
