<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationOrdersDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quotation_order_id')->nullable();
            $table->string('description')->nullable();
            $table->integer('qty')->default(0);
            $table->string('unit')->nullable();
            $table->string('notes')->nullable();
            $table->integer('price')->default(0);
            $table->tinyInteger('flag')->default(0);
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
        Schema::dropIfExists('quotation_details');
    }
}
