<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('company')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('position');
            $table->text('job_description');
            $table->timestamps();
        });
         Schema::table('work_histories', function($table) {
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
        Schema::drop('work_histories');
    }
}
