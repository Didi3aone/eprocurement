<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vendor_id');
            $table->string('doc_type_rfq');
            $table->string('doc_type_po');
            $table->bigInteger('rfq_number');
            $table->bigInteger('po_number');
            $table->string('plant');
            $table->integer('acp_id')->default(0);
            $table->timestamps();
        });

        Schema::create('rfq_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rfq_number');
            $table->bigInteger('po_item');
            $table->string('material_id')->nullable();
            $table->string('short_text')->nullable();
            $table->string('plant_code')->nullable();
            $table->string('storage_location_code')->nullable();
            $table->decimal('qty',16,2)->default('0.00');
            $table->string('unit')->nullable();
            $table->decimal('net_price',16,2)->default('0.00');
            $table->string('tax_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rfqs');
    }
}
