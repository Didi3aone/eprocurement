<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBillingDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('billing_details', function (Blueprint $table) {
            $table->string('PO_ITEM',10)->nullable();
            $table->string('material_id',20)->nullable();
            $table->string('debet_credit',2)->nullable();
        });

        Schema::table('purchase_order_gr', function (Blueprint $table) {
            $table->decimal('qty_billing',10,2)->default(0.00);
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
