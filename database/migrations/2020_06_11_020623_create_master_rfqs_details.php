<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterRfqsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_rfqs_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rfq_id')->nullable();
            $table->string('purchasing_document')->nullable();
            $table->string('item')->nullable();
            $table->string('document_item')->nullable();
            $table->string('deletion_indicator')->nullable();
            $table->string('status')->nullable();
            $table->string('last_changed_on')->nullable();
            $table->string('short_text')->nullable();
            $table->string('material')->nullable();
            $table->string('company_code')->nullable();
            $table->string('plant')->nullable();
            $table->string('storage_location')->nullable();
            $table->string('req_tracking_number')->nullable();
            $table->string('material_group')->nullable();
            $table->string('purchasing_info_rec')->nullable();
            $table->string('supplier_material_number')->nullable();
            $table->double('target_quantity')->nullable();
            $table->double('order_quantity')->nullable();
            $table->string('order_unit')->nullable();
            $table->string('order_price_unit')->nullable();
            $table->integer('quantity_conversion')->nullable();
            $table->integer('equal_to')->nullable();
            $table->integer('denominal')->nullable();
            $table->double('net_order_price')->nullable();
            $table->integer('price_unit')->nullable();
            $table->double('net_order_value')->nullable();
            $table->double('gross_order_value')->nullable();
            $table->date('quotation_deadline')->nullable();
            $table->integer('gr_processing_time')->nullable();
            $table->string('tax_code')->nullable();
            $table->string('base_unit_of_measures')->nullable();
            $table->string('shipping_intr')->nullable();
            $table->double('oa_target_value')->nullable();
            $table->double('non_deductible')->nullable();
            $table->double('stand_rel_order_qty')->nullable();
            $table->date('price_date')->nullable();
            $table->string('purchasing_doc_category')->nullable();
            $table->double('net_weight')->nullable();
            $table->string('unit_of_weight')->nullable();
            $table->string('material_type')->nullable();
            $table->date('creation_date')->nullable();
            $table->string('creation_time')->nullable();
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
        Schema::dropIfExists('master_rfqs_details');
    }
}
