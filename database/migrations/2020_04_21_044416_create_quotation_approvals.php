<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationApprovals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nik')->nullable();
            $table->tinyInteger('approval_position')->default(1);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('flag')->default(0);
            $table->integer('quotation_id')->nullable();
            $table->datetime('approve_date')->nullable();
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
        Schema::dropIfExists('quotation_approvals');
    }
}
