<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('vendor_id');
            $table->integer('user_id')->nullable(); //does this belong to an employee?
            $table->integer('created_by_user_id'); //who created this
            $table->timestamps();
        });

        Schema::create('distribution_project', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('distribution_id');
            $table->integer('project_id');
            $table->integer('percent');
            $table->integer('created_by_user_id'); //who created this
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
        Schema::dropIfExists('distributions');
        Schema::dropIfExists('distribution_project');
    }
}
