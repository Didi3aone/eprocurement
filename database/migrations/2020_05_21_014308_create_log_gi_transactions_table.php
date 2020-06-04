<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogGiTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_gi_transactions', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('request_no',20)->nullable();
            $table->bigInteger('rn_detail_id');
            $table->string('material_id');
            $table->string('qty_stock',20)->nullable();
            $table->string('qty_gi',20)->nullable();
            $table->string('MAT_DOC',30)->nullable();
            $table->string('DOC_YEAR',30)->nullable();
            $table->dateTime('transaction_date');
            $table->string('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_gi_transactions');
    }
}
