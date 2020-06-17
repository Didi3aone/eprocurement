<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_terms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment_terms',10);
            $table->bigInteger('day_limit')->default(0);
            $table->string('date_type',10)->nullable();
            $table->bigInteger('fixed_day')->default(0);
            $table->string('additional_months')->nullabel()->default(0);
            $table->bigInteger('no_of_days')->default(0);
            $table->string('percentage')->nullable();
            $table->bigInteger('no_of_days_2')->default(0);
            $table->string('percentage_2')->nullable();
            $table->bigInteger('no_of_days_3')->default(0);
            $table->bigInteger('fixed_day_2')->default(0);
            $table->string('additional_months_terms_2')->nullable()->default(0);
            $table->bigInteger('fixed_day_3')->default(0);
            $table->string('additional_months_terms_3')->nullable()->default(0);
            $table->bigInteger('fixed_day_4')->default(0);
            $table->string('additional_months_terms_4')->nullable()->default(0);
            $table->string('print_of_payment')->nullable();
            $table->string('block_key')->nullable();
            $table->string('transf_payment_boc')->nullable();
            $table->string('standart_text')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('transf_payment_moc')->nullable();
            $table->string('account_type')->nullable();
            $table->string('installment_payments')->nullable();
            $table->string('rec_entries')->nullable();
            $table->string('hide_entry')->nullable();
            $table->string('own_explanation')->nullable();
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
        Schema::dropIfExists('payment_terms');
    }
}
