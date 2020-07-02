<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserVendorsImportTable20200701012400 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_vendors_import', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vendor')->nullable();
            $table->string('country')->nullable();
            $table->string('name')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('search_term')->nullable();
            $table->string('street')->nullable();
            $table->string('street_2')->nullable();
            $table->string('street_3')->nullable();
            $table->string('street_4')->nullable();
            $table->string('street_5')->nullable();
            $table->string('title')->nullable();
            $table->string('account_group')->nullable();
            $table->string('tax_number_1')->nullable();
            $table->string('telephone_1')->nullable();
            $table->string('telephone_2')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('user_vendors_import');
    }
}
