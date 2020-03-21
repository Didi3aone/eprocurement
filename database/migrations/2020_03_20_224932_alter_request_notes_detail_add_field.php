<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRequestNotesDetailAddField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_notes_detail', function (Blueprint $table) {
            $table->bigInteger('price')->nullable()->default(0);
            $table->integer('is_available_stock')->nullable()->default(0);
            $table->integer('status')->nullable()->default(0);
            $table->integer('is_assets')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_notes_detail', function (Blueprint $table) {
            $table->dropColumn('price')->nullable()->default(0);
            $table->dropColumn('is_available_stock')->nullable()->default(0);
            $table->dropColumn('status')->nullable()->default(0);
            $table->dropColumn('is_assets')->nullable()->default(0);
        });
    }
}
