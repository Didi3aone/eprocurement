<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiddingHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidding_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pr_no')->notNullable();
            $table->integer('vendor_id')->notNullable();
            $table->integer('quotation_id')->notNullable();
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
        Schema::dropIfExists('bidding_history');
    }
}
