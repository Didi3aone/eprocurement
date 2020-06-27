<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterVendorPlanningGroupTable20200627014800 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_vendor_planning_group', function (Blueprint $table) {
            $table->bigIncrements('id', true);
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });

        $data = [
            ['code' => 'A1', 'name' => 'Domestic Payment'],
            ['code' => 'A2', 'name' => 'Foreign Payment']
        ];
        DB::table('master_vendor_planning_group')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_vendor_planning_group');
    }
}
