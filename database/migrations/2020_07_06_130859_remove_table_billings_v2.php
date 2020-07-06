<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTableBillingsV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->dropColumn('nominal_pajak');
            $table->dropColumn('nominal_claim');
            $table->dropColumn('potongan_pph');
            $table->dropColumn('partner_bank');
            $table->dropColumn('total_invoice');
            $table->dropColumn('berita_acara');
            $table->dropColumn('no_eprop');
            $table->dropColumn('perjanjian_kerjasama');
            $table->dropColumn('file_billing');
            $table->dropColumn('tgl_surat_jalan');
            $table->date('base_line_date')->nullable();
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
            //
        });
    }
}
