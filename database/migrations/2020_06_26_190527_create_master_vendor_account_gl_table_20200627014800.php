<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterVendorAccountGlTable20200627014800 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_vendor_account_gl', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        $data = [
            ['code' => '2111011001', 'name' => 'Account Payable Local'],
            ['code' => '2111021001', 'name' => 'Account Payable Import']
        ];
        DB::table('master_vendor_account_gl')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_vendor_account_gl');
    }
}
