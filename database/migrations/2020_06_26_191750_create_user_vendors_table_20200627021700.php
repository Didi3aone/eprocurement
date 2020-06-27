<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserVendorsTable20200627021700 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable(); 
            $table->string('vendor_title_id')->nullable(); 
            $table->string('vendor_bp_group_id')->nullable(); 
            $table->string('specialize')->nullable(); 
            $table->string('company_name')->nullable();
            $table->string('different_city')->nullable(); 
            $table->string('city')->nullable(); 
            $table->string('country')->nullable(); 
            $table->string('street')->nullable(); 
            $table->string('street_2')->nullable(); 
            $table->string('street_3')->nullable(); 
            $table->string('street_4')->nullable(); 
            $table->string('street_5')->nullable(); 
            $table->string('language')->nullable(); 
            $table->string('office_telephone'); 
            $table->string('telephone_2')->nullable(); 
            $table->string('telephone_3')->nullable(); 
            $table->string('office_fax'); 
            $table->string('fax_2')->nullable(); 
            $table->string('name')->nullable(); 
            $table->string('email')->nullable(); 
            $table->string('email_2')->nullable(); 
            $table->string('password')->nullable(); 
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
        Schema::dropIfExists('user_vendors');
    }
}
