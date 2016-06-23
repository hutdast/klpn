<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLottosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottos', function (Blueprint $table) {
            $table->increments('lotto_id');
            $table->string('username');
            $table->text('payload');
           $table->timestamps(); 
        });
        Schema::table('lottos', function($table) {
       $table->foreign('username')->references('name')->on('users')->onUpdate('cascade');
   });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lottos');
    }
}
