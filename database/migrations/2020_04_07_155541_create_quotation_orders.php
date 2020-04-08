<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vendor_id')->nullable();
            $table->string('po_no')->nullable();
            $table->string('po_date')->nullable();
            $table->string('notes')->nullable();
            $table->integer('request_id')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('quotation');
    }
}
