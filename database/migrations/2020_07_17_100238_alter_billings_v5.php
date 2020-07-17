<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBillingsV5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('billings', function (Blueprint $table) {
            // $table->date('verify_date')->nullable();
            // $table->string('payment_block')->nullable();
            $table->decimal('nominal_balance',16,2)->default('0.00');
        });
        // Schema::table('billing_details', function (Blueprint $table) {
        //     $table->decimal('qty_billing',16,2)->default('0.00');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('billings', function (Blueprint $table) {
            //
        });
    }
}
