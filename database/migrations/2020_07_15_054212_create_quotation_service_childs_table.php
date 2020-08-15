<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationServiceChildsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_service_childs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quotation_id');
            $table->integer('quotation_detail_id');
            $table->string('preq_item');
            $table->string('po_item');
            $table->string('package_no');
            $table->string('subpackage_no');
            $table->string('short_text');
        });

        Schema::create('purchase_order_service_childs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('purchase_order_id');
            $table->integer('purchase_order_detail_id');
            $table->string('preq_item');
            $table->string('po_item');
            $table->string('package_no');
            $table->string('subpackage_no');
            $table->string('short_text');
        });

        Schema::table('master_acps', function (Blueprint $table) {
            $table->string('plant_id')->nullable();    
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_service_childs');
    }
}
