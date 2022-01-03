<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->string('first_name')->after('id')->nullable();
           $table->string('last_name')->after('first_name')->nullable();
           $table->string('image')->after('name')->nullable();
           $table->string('phone')->after('email')->nullable();
           $table->longText('address')->after('phone')->nullable();
           $table->string('nid')->after('address')->nullable();
           $table->string('position')->after('nid')->nullable();
           $table->longText('about')->after('position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
