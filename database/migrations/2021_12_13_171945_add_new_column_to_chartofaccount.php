<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToChartofaccount extends Migration
{

    public function up()
    {
        Schema::table('chartofaccounts', function (Blueprint $table) {
            $table->string('child_head_id')->after('sub_head_name')->default(0)->nullable();
            $table->string('child_head_name')->after('sub_head_name')->default(0)->nullable();
        });
    }
    public function down()
    {
        Schema::table('chartofaccounts', function (Blueprint $table) {
            //
        });
    }
}
