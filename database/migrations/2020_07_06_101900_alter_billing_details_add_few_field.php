<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBillingDetailsAddFewField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('billing_details', function (Blueprint $table) {
            $table->bigInteger('plant_code')->nullable();
            $table->bigInteger('gl_account')->nullable();
            $table->bigInteger('profit_center')->nullable();
            $table->decimal('amount',16,2)->nullable();
            $table->bigInteger('material_document')->nullable();
            $table->bigInteger('reference_document_item')->nullable();
            $table->bigInteger('doc_gr')->nullable();
            $table->string('currency')->nullable();
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
