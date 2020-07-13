<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequestServiceChilds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_request_service_childs', function (Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('purchase_detail_id');
            $table->string('preq_item');
            $table->string('package_no');
            $table->string('subpackage_no');
            $table->string('short_text');
            $table->string('purchase_request_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_request_service_childs');
    }
}
