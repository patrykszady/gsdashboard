<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('business_name');
            $table->string('address')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('biz_phone')->nullable();
            $table->integer('biz_type'); // 1=subcontractor 2=vendor //3=employee
            $table->integer('created_by_user_id'); //who created this Vendor
            $table->string('note')->nullable();
            $table->timestamps();
        });

        Schema::create('user_vendor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('vendor_id');
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
        Schema::dropIfExists('vendors');
        Schema::dropIfExists('user_vendor');
    }
}
