<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hours', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('hourly'); //hourly rate in $
            $table->integer('project_id');
            $table->integer('check_id')->nullable();
            $table->string('note')->nullable();
            $table->integer('hours'); //how many hours on project
            $table->integer('user_id');
            $table->float('amount');
            $table->integer('created_by_user_id')->nullable(); //who created this
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
        Schema::dropIfExists('hours');
    }
}
