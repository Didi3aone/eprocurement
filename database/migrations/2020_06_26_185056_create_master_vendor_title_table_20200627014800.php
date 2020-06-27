<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterVendorTitleTable20200627014800 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_vendor_title', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        $data = [
            ['code' => '0003', 'name' => 'Company'],
            ['code' => '0005', 'name' => 'PT'],
            ['code' => '0006', 'name' => 'CV'],
            ['code' => '0007', 'name' => 'Toko'],
            ['code' => '0008', 'name' => 'PD'],
            ['code' => '0009', 'name' => 'UD'],
            ['code' => '0010', 'name' => 'Ltd'],
            ['code' => '0011', 'name' => 'Co, Ltd.'],
            ['code' => '0012', 'name' => 'Inc.'],
            ['code' => '0013', 'name' => 'Gmbh'],
            ['code' => '0014', 'name' => 'SE'],
            ['code' => '0015', 'name' => 'AG'],
            ['code' => '0016', 'name' => 'Tbk'],
            ['code' => '0017', 'name' => 'Fa'],
            ['code' => '0018', 'name' => 'NV']
        ];
        DB::table('master_vendor_title')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_vendor_title');
    }
}
