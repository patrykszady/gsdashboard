<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->date('expense_date');
            $table->float('amount');
            $table->integer('project_id');
            $table->integer('vendor_id');
            $table->string('paid_by'); //Company owns Vendor OR User::where(vendor_id = $this) this Expense. ID number.
            $table->string('invoice')->nullable(); //invoice #
            $table->string('check_id')->nullable(); //company check # Expense paid with
            $table->string('reimbursment')->nullable(); //Client OR Vendor to pay Company back this Expense
            $table->string('note')->nullable();
            $table->integer('created_by_user_id'); //who created this expense  // Auth:user()? 
            $table->string('receipt')->nullable(); //receipt URI
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
        Schema::dropIfExists('expenses');
    }
}
