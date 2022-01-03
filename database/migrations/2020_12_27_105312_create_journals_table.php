<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalsTable extends Migration
{

    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sister_concern_id')->nullable();
            $table->string('voucher_no')->nullable();
            $table->string('voucher_type')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('debit_id')->nullable();
            $table->string('debit_amount')->nullable();
            $table->string('credit_id')->nullable();
            $table->string('credit_amount')->nullable();
            $table->longText('naration')->nullable();
            $table->string('transfer_amount_to')->nullable();
            $table->string('debit_overview')->nullable();
            $table->string('debit_amount_overview')->nullable();
            $table->string('transfer_amount_from')->nullable();
            $table->string('credit_overview')->nullable();
            $table->string('credit_amount_overview')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('journals');
    }
}
