<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveField2PurchaseRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->dropColumn('account_assignment_code');
            $table->dropColumn('release_date');
            $table->dropColumn('uom');
            $table->dropColumn('approval_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->dropColumn('account_assignment_code');
            $table->dropColumn('release_date');
            $table->dropColumn('uom');
            $table->dropColumn('approval_status');
        });
    }
}
