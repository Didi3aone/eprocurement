<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('request_no');
            $table->string('notes')->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_notes');
    }
}
