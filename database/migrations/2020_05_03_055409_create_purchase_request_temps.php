<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequestTemps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_request_temps', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('request_no');
            $table->string('notes');
            $table->date('request_date');
            $table->bigInteger('total');
            $table->integer('status')->default(0);
            $table->string('doc_type',40)->nullable();
            $table->string('upload_file')->nullable();
            $table->timestamps();
            $table->string('created_by',10)->nullable();
            $table->string('updated_by',10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_request_temps');
    }
}
