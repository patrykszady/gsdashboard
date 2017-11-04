<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mailbox');
            $table->string('from_address');
            $table->integer('created_by_user_id');
            $table->integer('vendor_id');
            $table->integer('project_id')->nullable();
            $table->integer('distribution_id')->nullable();
            $table->string('receipt_start')->nullable();
            $table->string('receipt_end')->nullable();
            $table->integer('po'); //yer or no
            $table->string('po_start')->nullable();
            $table->string('po_end')->nullable();
            $table->string('amount_start');
            $table->string('amount_end');
            $table->integer('receipt_type'); //yer or no
            $table->integer('attached_receipt'); //yer or no
            $table->string('receipt_filename'); //inlcuding extension
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
        Schema::dropIfExists('receipts');
    }
}
