<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapLeadtimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_leadtimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('material_id')->nullable();
            $table->string('description')->nullable();
            $table->string('plant')->nullable();
            $table->string('planned_deliv_time')->nullable();
            $table->string('gr_processing_time')->nullable();
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
        Schema::dropIfExists('rekap_leadtimes');
    }
}
