<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterRfqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_rfq', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vendor_id');
            $table->string('rfq_doc');
            $table->string('rfq_number');
            $table->string('po_number')->nullable();
            $table->string('po_doc')->nullable();
            $table->string('material_id')->nullable();
            $table->string('short_text')->nullable();
            $table->string('plant')->nullable();
            $table->decimal('qty',16,2)->default('0.00');
            $table->string('unit')->nullable();
            $table->decimal('net_price',16,2)->default('0.00');
            $table->string('tax_code')->nullable();
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
        Schema::dropIfExists('master_rfq');
    }
}
