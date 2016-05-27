<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bios', function (Blueprint $table) {
            $table->increments('id');
             $table->string('username');
            $table->string('motto')->nullable();
            $table->text('short_intro')->nullable();
            $table->longText('self_description')->nullable();
            $table->timestamps();
        });
         Schema::table('bios', function($table) {
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
        Schema::drop('bios');
    }
}
