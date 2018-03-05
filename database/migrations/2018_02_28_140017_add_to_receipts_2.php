<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToReceipts2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->integer('from_type')->after('mailbox');
            $table->string('from_subject')->after('from_address')->nullable();
            $table->string('from_address')->nullable()->change();
            $table->dropColumn('mailbox');
            $table->dropColumn('project_id');
            $table->dropColumn('distribution_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn('from_type');
            $table->dropColumn('from_subject');
            $table->string('mailbox')->after('id');
            $table->string('project_id');
            $table->string('distribution_id');
        });
    }
}
