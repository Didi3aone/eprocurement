<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterRfqs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_rfqs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('purchasing_document')->nullable();
            $table->integer('company_code')->nullable();
            $table->string('purchasing_doc_category')->nullable();
            $table->string('purchasing_doc_type')->nullable();
            $table->string('deletion_indicator')->nullable();
            $table->string('status')->nullable();
            $table->string('created_on')->nullable();
            $table->string('created_by')->nullable();
            $table->string('last_changed')->nullable();
            $table->bigInteger('vendor')->nullable();
            $table->string('language_key')->nullable();
            $table->string('payment_terms')->nullable();
            $table->integer('payment_in1')->nullable();
            $table->integer('payment_in2')->nullable();
            $table->integer('payment_in3')->nullable();
            $table->double('disc_percent1')->nullable();
            $table->double('disc_percent2')->nullable();
            $table->string('purchasing_organization_default')->default('0000');
            $table->string('purchasing_group')->nullable();
            $table->string('currency')->nullable();
            $table->string('exchange_rate')->nullable();
            $table->string('fixed_exchange_rate')->nullable();
            $table->date('document_date')->nullable();
            $table->date('quotation_deadline')->nullable();
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
        Schema::dropIfExists('master_rfqs');
    }
}
