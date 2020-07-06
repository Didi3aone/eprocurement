<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempPurchaseRequestDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_purchase_requests', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('notes')->nullable();
            $table->string('category')->nullable();
            $table->string('PR_NO')->nullable();
            $table->string('description');
            $table->decimal('qty',10,2);
            $table->string('unit');
            $table->string('material_id');
            $table->string('request_no')->nullable();
            $table->string('assets_no')->nullable();
            $table->string('text_id')->nullable();
            $table->string('text_form')->nullable();
            $table->string('text_line')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('release_date')->nullable();
            $table->string('account_assignment')->nullable();
            $table->string('preq_item')->nullable();
            $table->string('material_group')->nullable();
            $table->string('purchasing_group_code')->nullable();
            $table->string('storage_location')->nullable();
            $table->string('plant_code')->nullable();
            $table->string('preq_name')->nullable();
            $table->string('profit_center_code')->nullable();
            $table->string('short_text')->nullable();
            $table->string('doc_type')->nullable();
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
        Schema::dropIfExists('temp_purchase_request_details');
    }
}
