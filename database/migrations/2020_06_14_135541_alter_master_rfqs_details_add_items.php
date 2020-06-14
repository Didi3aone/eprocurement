<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMasterRfqsDetailsAddItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_rfqs_details', function (Blueprint $table) {
            $table->string('profit_center')->nullable();
            $table->string('gross_weight')->nullable();
            $table->string('package_number')->nullable();
            $table->string('mat_ledger_active')->nullable();
            $table->string('purchase_requisition')->nullable();
            $table->string('item_of_requisition')->nullable();
            $table->string('rebate_basis')->nullable();
            $table->string('requisitioner')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_rfqs_details', function (Blueprint $table) {
            $table->dropColumn('profit_center');
            $table->dropColumn('gross_weight');
            $table->dropColumn('package_number');
            $table->dropColumn('mat_ledger_active');
            $table->dropColumn('purchase_requisition');
            $table->dropColumn('item_of_requisition');
            $table->dropColumn('rebate_basis');
            $table->dropColumn('requisitioner');
        });
    }
}
