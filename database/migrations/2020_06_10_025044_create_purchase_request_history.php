<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequestHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_request_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pr_id')->nullable();
            $table->string('purchase_id')->nullable();
            $table->string('request_no')->nullable();
            $table->string('material_id')->nullable();
            $table->string('vendor_id')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('price')->nullable();
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
        Schema::dropIfExists('purchase_request_history');
    }
}
