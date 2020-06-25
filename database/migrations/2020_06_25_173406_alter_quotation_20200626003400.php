<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterQuotation20200626003400 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation', function (Blueprint $table) {
            $table->integer('approved_asspro')->nullable()->default(0)->index();
            $table->integer('approved_head')->nullable()->default(0)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotation', function (Blueprint $table) {
            $table->dropColumn('approved_asspro');
            $table->dropColumn('approved_head');
        });
    }
}
