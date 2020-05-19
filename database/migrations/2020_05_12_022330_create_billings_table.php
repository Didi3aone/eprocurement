<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->integer('tipe')->default(1);
            $table->string('billing_no',20)->nullable();
            $table->string('no_faktur',50)->nullable();
            $table->date('tgl_faktur',50)->nullable();
            $table->string('no_invoice',50)->nullable();
            $table->date('tgl_invoice',50)->nullable();
            $table->unsignedBigInteger('nominal_inv_after_ppn')->default(0);
            $table->string('ppn',50)->nullable();
            $table->string('dpp',50)->nullable();
            $table->string('no_rekening',50)->nullable();
            $table->string('no_surat_jalan',50)->nullable();
            $table->date('tgl_surat_jalan')->nullable();
            $table->string('npwp',50)->nullable();
            $table->text('surat_ket_bebas_pajak')->nullable();
            $table->text('po')->nullable();
            $table->text('keterangan_po')->nullable();
            $table->string('no_eprop')->nullable();
            $table->text('perjanjian_kerjasama')->nullable();
            $table->text('berita_acara')->nullable();
            $table->text('file_billing')->nullable();
            $table->text('file_faktur')->nullable();
            $table->text('file_invoice')->nullable();
            $table->integer('status')->default(1);
            $table->bigInteger('vendor_id')->default(1);
            $table->timestamps();
            $table->string('created_by',10)->nullable();
            $table->string('updated_by',10)->nullable();
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
        Schema::dropIfExists('billings');
    }
}
