<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSisterConcernIdToUsersTable extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('sister_concern_id')->default(0)->nullable()->after('id');
        });
    }
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
