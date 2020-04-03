<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRequestNotesDetailsRenameTypeRequestId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_notes_details', function (Blueprint $table) {
            // $table->integer('request_id')->nullable()->change();
            DB::statement('ALTER TABLE request_notes_details ALTER request_id TYPE INT USING (trim(request_id)::int)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_notes_details', function (Blueprint $table) {
            DB::statement('ALTER TABLE request_notes_details ALTER request_id TYPE VARCHAR');
            // $table->string('request_id')->nullable()->change();
        });
    }
}
