<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterVendorBpGroupTable20200627014800 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_vendor_bp_group', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        $data = [
            ['code' => 'Z001', 'name' => 'RMPM lokal'],
            ['code' => 'Z002', 'name' => 'RMPM Import'],
            ['code' => 'Z003', 'name' => 'INDIRECT lokal'],
            ['code' => 'Z004', 'name' => 'INDIRECT import']
        ];
        DB::table('master_vendor_bp_group')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_vendor_bp_group');
    }
}
