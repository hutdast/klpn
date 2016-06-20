<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLottoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lotto', function (Blueprint $table) {
             $table->increments('lotto_id');
            $table->mediumText('payload');
            $table->timestamps('date_created');
        });
         Schema::table('lotto', function($table) {
       $table->foreign('lotto_id')->references('id')->on('users');
   });
   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lotto', function (Blueprint $table) {
            Schema::drop('lotto');
        });
    }
}
