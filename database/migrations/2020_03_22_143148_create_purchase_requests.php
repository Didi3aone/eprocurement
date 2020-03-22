<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('request_no')->nullable();
            $table->date('date')->nullable();
            $table->string('notes')->nullable();
            $table->integer('rate_from')->nullable();
            $table->integer('rate_to')->nullable();
            $table->integer('approval_position')->nullable();
            $table->integer('total')->nullable();
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_requests');
    }
}
