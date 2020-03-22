<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequestsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_requests_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('purchase_id')->nullable();
            $table->string('description')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('unit')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('purchase_requests_details');
    }
}
