<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBillingDetailV3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('billing_details', function (Blueprint $table) {
            $table->string('reference_document')->nullable();
            $table->decimal('price_per_pc',16,2)->nullable();
            $table->string('material_doc_item')->nullable();
            $table->string('reference_document_item')->change();
        });
        Schema::table('billings', function (Blueprint $table) {
            $table->string('house_bank')->change();
            $table->string('partner_bank')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('billing_details', function (Blueprint $table) {
            //
        });
    }
}
