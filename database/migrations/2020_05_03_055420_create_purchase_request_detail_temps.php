<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequestDetailTemps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_request_detail_temps', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('request_id');
            $table->string('description')->nullable();
            $table->integer('qty')->nullable()->default(0);
            $table->string('unit',20)->nullable();
            $table->string('notes',100)->nullable();
            $table->bigInteger('price')->default(0);
            $table->string('material_id')->nullable();
            $table->string('request_no')->nullable();
            $table->integer('is_asstes')->default(0);
            $table->string('assets_no')->nullable();
            $table->string('short_text')->nullable();
            $table->string('text_id')->nullable();
            $table->string('text_form')->nullable();
            $table->string('text_line')->nullable();
            $table->string('delivery_date_category')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('release_date')->nullable();
            $table->string('account_assignment',10)->nullable();
            $table->string('gr_ind',10)->nullable();
            $table->string('ir_ind',10)->nullable();
            $table->string('purchasing_group_code',10)->nullable();
            $table->string('preq_name')->nullable();
            $table->string('plant_code',10)->nullable();
            $table->string('gl_acct_code',30)->nullable();
            $table->string('cost_center_code',30)->nullable();
            $table->string('co_area',30)->nullable();
            $table->string('profit_center_code',30)->nullable();
            $table->string('func_area',30)->nullable();
            $table->string('storage_location',30)->nullable();
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
        Schema::dropIfExists('purchase_request_detail_temps');
    }
}
