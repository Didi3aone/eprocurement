<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterVendorTermsOfPaymentTable20200629012400 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_vendor_terms_of_payment', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->string('code');
            $table->string('description');
            $table->timestamps();
        });

        $data = [
            ['code' => 'Z000', 'description' => 'Cash'],
            ['code' => 'Z007', 'description' => 'within 7 days Due net'],
            ['code' => 'Z018', 'description' => '18 Days Credit'],
            ['code' => 'Z022', 'description' => '22 Days Credit'],
            ['code' => 'Z024', 'description' => '24 Days Credit'],
            ['code' => 'Z028', 'description' => '28 Days Credit'],
            ['code' => 'Z029', 'description' => '29 Days Credit'],
            ['code' => 'Z030', 'description' => '30 Days Credit'],
            ['code' => 'Z031', 'description' => '31 Days Credit'],
            ['code' => 'Z032', 'description' => '32 Days Credit'],
            ['code' => 'Z034', 'description' => '34 Days Credit'],
            ['code' => 'Z035', 'description' => '35 Days Credit'],
            ['code' => 'Z036', 'description' => '36 Days Credit'],
            ['code' => 'Z037', 'description' => '37 Days Credit'],
            ['code' => 'Z039', 'description' => '39 Days Credit'],
            ['code' => 'Z040', 'description' => '40 Days Credit'],
            ['code' => 'Z042', 'description' => '42 Days Credit'],
            ['code' => 'Z044', 'description' => '44 Days Credit'],
            ['code' => 'Z045', 'description' => '45 Days Credit'],
            ['code' => 'Z046', 'description' => '46 Days Credit'],
            ['code' => 'Z047', 'description' => '47 Days Credit'],
            ['code' => 'Z050', 'description' => '50 Days Credit'],
            ['code' => 'Z054', 'description' => '54 Days Credit'],
            ['code' => 'Z060', 'description' => 'within 60 days Due net'],
            ['code' => 'Z067', 'description' => 'within 67 days Due net'],
            ['code' => 'Z082', 'description' => 'within 82 days Due net'],
            ['code' => 'Z090', 'description' => 'within 90 days Due net']
        ];
        DB::table('master_vendor_terms_of_payment')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_vendor_terms_of_payment');
    }
}
