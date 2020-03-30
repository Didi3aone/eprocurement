<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPurchaseRequestsDetailsAddMoreDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requests_details', function (Blueprint $table) {
            $table->string('short_text')->nullable();
            $table->string('text_id')->nullable();
            $table->string('text_form')->nullable();
            $table->string('text_line')->nullable();
            $table->string('delivery_date_category')->nullable();
            $table->string('delivery_date')->nullable();
            $table->string('release_date')->nullable();
            $table->string('account_assignment')->nullable();
            $table->string('gr_ind')->nullable();
            $table->string('ir_ind')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_requests_details', function (Blueprint $table) {
            $table->dropColumn('short_text');
            $table->dropColumn('text_id');
            $table->dropColumn('text_form');
            $table->dropColumn('text_line');
            $table->dropColumn('delivery_date_category');
            $table->dropColumn('delivery_date');
            $table->dropColumn('release_date');
            $table->dropColumn('account_assignment');
            $table->dropColumn('gr_ind');
            $table->dropColumn('ir_ind');
        });
    }
}
