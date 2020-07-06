<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBillingDetailsAddFewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('billing_details', function (Blueprint $table) {
            $table->bigInteger('item_gr')->nullable();
            $table->string('tahun_gr')->nullable();
            $table->string('storage_location')->nullable();
            $table->string('unit')->nullable();
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
