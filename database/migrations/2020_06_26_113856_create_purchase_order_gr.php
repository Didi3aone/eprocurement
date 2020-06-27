<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderGr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_gr', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('po_no')->nullable();
            $table->string('po_item')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('movement_type')->nullable();
            $table->string('debet_credit')->nullable()->comment('S: debet, H: credit');
            $table->string('material_no')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('plant')->nullable();
            $table->string('storage_location')->nullable();
            $table->string('batch')->nullable();
            $table->string('satuan')->nullable();
            $table->string('currency')->default('IDR')->nullable();
            $table->string('doc_gr')->nullable();
            $table->integer('tahun_gr')->nullable();
            $table->string('item_gr')->nullable();
            $table->string('reference_document')->nullable();
            $table->string('reference_document_item')->nullable();
            $table->string('material_document')->nullable();
            $table->string('material_doc_item')->nullable();
            $table->string('delivery_completed')->nullable();
            $table->string('gl_account')->nullable();
            $table->string('profit_center')->nullable();
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
        Schema::dropIfExists('purchase_order_gr');
    }
}
