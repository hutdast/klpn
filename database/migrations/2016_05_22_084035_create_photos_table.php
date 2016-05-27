<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
             $table->string('username');
            $table->string('url');
            $table->string('for_section')->nullable();
            $table->timestamps();
        });
        Schema::table('photos', function($table) {
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
        Schema::drop('photos');
    }
}
