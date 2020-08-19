<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldSoftdeleted extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_acp_materials', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('master_acp_vendors', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('quotation', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('quotation_details', function (Blueprint $table) {
            $table->softDeletes();
        });


        Schema::table('billing_details', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('purchase_orders_details', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('quotation_deliverys', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('quotation_service_childs', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('quotation_approvals', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('purchase_order_delivery', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('purchase_order_service_childs', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
