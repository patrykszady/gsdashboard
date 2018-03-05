<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_email_id');
            $table->integer('receipt_id');
            $table->integer('project_id')->nullable();
            $table->integer('distribution_id')->nullable();
            $table->integer('created_by_user_id');
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
        Schema::dropIfExists('receipt_accounts');
    }
}
