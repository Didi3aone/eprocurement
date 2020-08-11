<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRfqDetailsV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rfq_details', function (Blueprint $table) {
            // $table->string('purchasing_group_code')->nullable();
            $table->decimal('per_unit',16,2)->default('0.00');
            $table->decimal('total_price',16,2)->default('0.00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rfq_details', function (Blueprint $table) {
            //
        });
    }
}
