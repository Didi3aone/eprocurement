<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('billing_no',20)->nullable();
            $table->string('faktur_no',50)->nullable();
            $table->string('invoice_no',50)->nullable();
            $table->string('file_billing')->nullable();
            $table->string('file_faktur')->nullable();
            $table->string('file_invoice')->nullable();
            $table->date('faktur_date')->nullable();
            $table->date('invoice_date')->nullable();
            $table->integer('status')->default(1);
            $table->bigInteger('vendor_id')->default(1);
            $table->timestamps();
            $table->string('created_by',10)->nullable();
            $table->string('updated_by',10)->nullable();
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
        Schema::dropIfExists('billings');
    }
}
