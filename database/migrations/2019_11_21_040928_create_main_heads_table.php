<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_heads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_id')->nullable();
            $table->string('account_type')->nullable();
            $table->string('account_code')->nullable();
            $table->string('account_name')->nullable();
            $table->string('sub_account')->nullable();
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
        Schema::dropIfExists('main_heads');
    }
}
