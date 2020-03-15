<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVendorsFewFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('fax')->nullable();
            $table->string('phone')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('title')->nullable();
            $table->string('street')->nullable();
            $table->string('postal_code', 6)->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('tax')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->dropColumn('district');
            $table->dropColumn('postal_code');
            $table->dropColumn('street');
            $table->dropColumn('title');
            $table->dropColumn('tax_number');
            $table->dropColumn('phone');
            $table->dropColumn('fax');
            $table->dropColumn('tax');
        });
    }
}
