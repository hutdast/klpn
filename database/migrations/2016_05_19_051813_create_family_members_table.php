<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilyMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('nickname')->unique();
            $table->text('phone');
            $table->text('social_media');
            $table->date('birthday');
            $table->text('address');
            $table->timestamps();
           
        });
        
        Schema::table('family_members', function($table) {
       $table->foreign('nickname')->references('name')->on('users');
   });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('family_members');
    }
}
