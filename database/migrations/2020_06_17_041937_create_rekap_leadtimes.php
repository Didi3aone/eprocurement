<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapLeadtimes extends Migration
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
            $table->bigInteger('material_id')->default(0);
            $table->bigInteger('plant_code')->default(0);
            $table->string('valutation_type')->nullable();
            $table->string('purchasing_group',10)->nullable();
            $table->string('mrp_type',10)->nullable();
            $table->bigInteger('valuation_class')->default(0);
            $table->string('price_control',10)->nullable();
            $table->bigInteger('price')->nullable();
            $table->string('currency',10)->nullable();
            $table->string('price_unit',10)->nullable();
            $table->integer('lead_time_pr_po')->default(0);
            $table->integer('lead_time_po_gr')->default(0);
            $table->string('created_by')->nullable();
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
