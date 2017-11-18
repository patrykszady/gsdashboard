<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftdeleteToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hours', function($table) {
            $table->softDeletes();
        });
        Schema::table('expenses', function($table) {
            $table->softDeletes();
        });
        Schema::table('checks', function($table) {
            $table->softDeletes();
        });
        Schema::table('expense_splits', function($table) {
            $table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hours', function($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('expenses', function($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('checks', function($table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('expense_splits', function($table) {
            $table->dropColumn('deleted_at');
        });
    }
}
