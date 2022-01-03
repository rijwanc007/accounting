<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingsTable extends Migration
{

    public function up()
    {
        Schema::create('accountings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->nullable();
            $table->string('particular')->nullable();
            $table->string('amount')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('accountings');
    }
}
