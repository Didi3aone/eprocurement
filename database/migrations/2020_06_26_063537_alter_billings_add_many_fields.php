<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBillingsAddManyFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->string('proposal_id')->nullable();
            $table->string('document_no')->nullable();
            $table->string('title')->nullable();
            $table->string('proposal_date')->nullable();
            $table->string('division')->nullable();
            $table->string('region')->nullable();
            $table->string('file_principal')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_claim')->nullable();
            $table->string('file_copy_faktur')->nullable();
            $table->string('file_skp')->nullable();
            $table->string('claim_no')->nullable();
            $table->string('ktp_name')->nullable();
            $table->string('npwp_name')->nullable();
            $table->string('total_claim')->nullable();
            $table->string('posting_date')->nullable();
            $table->string('ktp_no')->nullable();
            $table->string('tipe_pajak')->nullable();
            $table->string('nominal_pajak')->nullable();
            $table->string('company_list')->nullable();
            $table->string('nominal_claim')->nullable();
            $table->string('perihal_claim')->nullable();
            $table->string('potongan_pph')->nullable();
            $table->string('jumlah_pph')->nullable();
            $table->string('partner_bank')->nullable();
            $table->string('payment_term_claim')->nullable();
            $table->string('gl_account')->nullable();
            $table->string('gl_value')->nullable();
            $table->string('cost_center')->nullable();
            $table->string('ar')->nullable();
            $table->string('ar_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->dropColumn('proposal_id');
            $table->dropColumn('document_no');
            $table->dropColumn('title');
            $table->dropColumn('proposal_date');
            $table->dropColumn('division');
            $table->dropColumn('region');
            $table->dropColumn('file_principal');
            $table->dropColumn('file_ktp');
            $table->dropColumn('file_claim');
            $table->dropColumn('file_copy_faktur');
            $table->dropColumn('file_skp');
            $table->dropColumn('claim_no');
            $table->dropColumn('ktp_name');
            $table->dropColumn('npwp_name');
            $table->dropColumn('total_claim');
            $table->dropColumn('posting_date');
            $table->dropColumn('ktp_no');
            $table->dropColumn('tipe_pajak');
            $table->dropColumn('nominal_pajak');
            $table->dropColumn('company_list');
            $table->dropColumn('nominal_claim');
            $table->dropColumn('perihal_claim');
            $table->dropColumn('potongan_pph');
            $table->dropColumn('jumlah_pph');
            $table->dropColumn('partner_bank');
            $table->dropColumn('payment_term_claim');
            $table->dropColumn('gl_account');
            $table->dropColumn('gl_value');
            $table->dropColumn('cost_center');
            $table->dropColumn('ar');
            $table->dropColumn('ar_value');
        });
    }
}
