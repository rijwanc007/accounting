<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartofaccountsTable extends Migration
{

    public function up()
    {
        Schema::create('chartofaccounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sister_concern_id')->nullable();
            $table->string('category')->nullable();
            $table->string('type')->nullable();
            $table->string('head_id')->nullable();
            $table->string('head_name')->nullable();
            $table->string('sub_head_id')->nullable();
            $table->string('sub_head_name')->nullable();
            $table->longText('narration')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('chartofaccounts');
    }
}
