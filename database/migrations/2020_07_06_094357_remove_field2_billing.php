<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveField2Billing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('proposal_id');
            $table->dropColumn('claim_no');
            $table->dropColumn('ktp_no');
            $table->dropColumn('tipe_pajak');
            $table->dropColumn('partner_bank');
            $table->dropColumn('division');
            $table->dropColumn('region');
            $table->dropColumn('file_principal');
            $table->dropColumn('file_ktp');
            $table->dropColumn('file_claim');
            $table->dropColumn('file_copy_faktur');
            $table->dropColumn('file_skp');
            $table->dropColumn('npwp_name');
            $table->dropColumn('ktp_name');
            $table->dropColumn('company_list');
            $table->dropColumn('gl_account');
            $table->dropColumn('gl_value');
            $table->dropColumn('cost_center');
            $table->bigInteger('house_bank')->nullable();
        });

        Schema::table('master_bank_house', function (Blueprint $table) {
            $table->renameColumn('plant_cde','plant_code');
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
