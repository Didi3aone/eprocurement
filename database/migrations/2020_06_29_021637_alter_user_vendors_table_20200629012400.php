<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserVendorsTable20200629012400 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE user_vendors ALTER COLUMN vendor_bp_group_id TYPE Bigint using vendor_bp_group_id::bigint");
        DB::statement("ALTER TABLE user_vendors ALTER COLUMN vendor_title_id TYPE Bigint using vendor_title_id::bigint");
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
