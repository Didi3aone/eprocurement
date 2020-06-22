<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMasterAcpsAddIsProjectIsApprovalAcp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_acps', function (Blueprint $table) {
            $table->tinyInteger('is_project')->default(0)->comment('0: non project, 1: is project');
            $table->tinyInteger('is_approval')->default(0)->comment('0: pending, 1: approved, 2: rejected');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_acps', function (Blueprint $table) {
            $table->dropColumn('is_project');
            $table->dropColumn('is_approval');
        });
    }
}
