<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRfqsDetailAddMaterial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rfqs_details', function (Blueprint $table) {
            $table->string('material_id')->nullable();
            $table->string('material_group')->nullable();
            $table->string('purchasing_info_rec')->nullable();
            $table->integer('target_quantity')->nullable();
            $table->double('order_quantity')->nullable();
            $table->string('order_unit')->nullable();
            $table->string('order_price_unit')->nullable();
            $table->integer('quantity_conversion')->nullable();
            $table->integer('equal_to')->nullable();
            $table->integer('denominal')->nullable();
            $table->integer('net_order_price')->nullable();
            $table->integer('price_unit')->nullable();
            $table->integer('net_order_value')->nullable();
            $table->integer('gross_order_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rfqs_details', function (Blueprint $table) {
            $table->dropColumn('material_id');
            $table->dropColumn('material_group');
            $table->dropColumn('purchasing_info_rec');
            $table->dropColumn('target_quantity');
            $table->dropColumn('order_quantity');
            $table->dropColumn('order_unit');
            $table->dropColumn('order_price_unit');
            $table->dropColumn('quantity_conversion');
            $table->dropColumn('equal_to');
            $table->dropColumn('denominal');
            $table->dropColumn('net_order_price');
            $table->dropColumn('price_unit');
            $table->dropColumn('net_order_value');
            $table->dropColumn('gross_order_value');
        });
    }
}