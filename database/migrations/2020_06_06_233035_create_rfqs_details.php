<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfqs_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('purchasing_document')->nullable();
            $table->integer('company_code')->nullable();
            $table->string('purchasing_doc_category')->nullable();
            $table->string('purchasing_doc_type')->nullable();
            $table->string('deletion_indicator')->nullable();
            $table->string('status')->nullable();
            $table->integer('vendor')->nullable();
            $table->string('language_key')->nullable();
            $table->integer('payment_terms')->nullable();
            $table->integer('payment_in1')->nullable();
            $table->integer('payment_in2')->nullable();
            $table->integer('payment_in3')->nullable();
            $table->double('disc_persent1')->nullable();
            $table->double('disc_persent2')->nullable();
            $table->string('purchasing_org')->nullable();
            $table->string('purchasing_group')->nullable();
            $table->string('currency')->nullable();
            $table->double('exchange_rate')->nullable();
            $table->string('exchange_rate_fixed')->nullable();
            $table->date('document_date')->nullable();
            $table->date('quotation_deadline')->nullable();
            $table->string('created_by')->nullable();
            $table->datetime('last_changed')->nullable();
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
        Schema::dropIfExists('rfqs_details');
    }
}
