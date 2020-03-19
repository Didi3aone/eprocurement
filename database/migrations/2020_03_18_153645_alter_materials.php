<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('departemen_peminta');
            $table->dropColumn('status');
            $table->string('small_description')->nullable();
            $table->string('description')->nullable();
            $table->integer('m_group_id')->nullable();
            $table->integer('m_type_id')->nullable();
            $table->integer('m_plant_id')->nullable();
            $table->integer('m_purchasing_id')->nullable();
            $table->integer('m_profit_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('small_description')->nullable();
            $table->dropColumn('description')->nullable();
            $table->dropColumn('m_group_id')->nullable();
            $table->dropColumn('m_type_id')->nullable();
            $table->dropColumn('m_plant_id')->nullable();
            $table->dropColumn('m_purchasing_id')->nullable();
            $table->dropColumn('m_profit_id')->nullable();
        });
    }
}
