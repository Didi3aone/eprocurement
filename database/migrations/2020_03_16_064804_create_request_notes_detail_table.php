<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestNotesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_notes_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('request_id');
            $table->string('material_id',20);
            $table->string('description',100);
            $table->bigInteger('qty')->nullable();
            $table->string('unit',10)->nullable();
            $table->string('notes', 200)->nullable();
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
        Schema::dropIfExists('request_notes_detail');
    }
}
