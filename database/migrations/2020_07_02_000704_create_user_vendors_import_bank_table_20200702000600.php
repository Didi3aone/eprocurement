<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserVendorsImportBankTable20200702000600 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_vendors_import_bank', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vendor')->nullable();
            $table->string('bank_country')->nullable();
            $table->string('bank_key')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_control_key')->nullable();
            $table->string('bank_type')->nullable();
            $table->string('collection_authorization')->nullable();
            $table->string('reference_details')->nullable();
            $table->string('account_holder')->nullable();
            $table->integer('has_migrate')->default(0);
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
        Schema::dropIfExists('user_vendors_import_bank');
    }
}
