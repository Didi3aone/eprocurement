<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('invoice_number');
            $table->string('fiscal_year');
            $table->string('billing_id');
            $table->timestamps();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('invoice_number')->nullable();
            $table->string('invoice_doc_item')->nullable();
            $table->string('po_number')->nullable();
            $table->string('po_item')->nullable();
            $table->string('ref_doc')->nullable();
            $table->string('ref_doc_it')->nullable();
            $table->string('tax_code')->nullable();
            $table->decimal('item_amount',16,2)->nullable();
            $table->decimal('qty',16,2)->nullable();
            $table->string('po_unit')->nullable();
            $table->string('po_pr_qty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
