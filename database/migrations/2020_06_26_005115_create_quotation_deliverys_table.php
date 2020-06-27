<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationDeliverysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_deliverys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quotation_id');
            $table->bigInteger('SCHED_LINE')->default(0);
            $table->bigInteger('PO_ITEM')->default(0);
            $table->date('DELIVERY_DATE');
            $table->string('PREQ_NO');
            $table->bigInteger('PREQ_ITEM')->default(0);
            $table->bigInteger('QUANTITY')->default(0);
        });

        Schema::table('master_acps', function (Blueprint $table) {
            $table->string('deleted_by')->nullable()->change();
        });

        Schema::table('quotation_details', function (Blueprint $table) {
            $table->bigInteger('PO_ITEM')->default(0);
            $table->date('delivery_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_deliverys');
    }
}
