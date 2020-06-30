<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddedAcpIdQuotDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation_details', function (Blueprint $table) {
            $table->integer('acp_id')->unsigned()->nullable()->default(0);
            $table->string('request_no')->nullable()->default(0);
            $table->string('currency')->nullable()->default('IDR');
            $table->bigInteger('orginal_price')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotation_details', function (Blueprint $table) {
            //
        });
    }
}
