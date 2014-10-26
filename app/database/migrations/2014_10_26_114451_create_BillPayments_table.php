<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('BillPayments', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> integer('BillNo')->nullable()->unsigned();
			$table->timestamp('PaymentDate')->nullable();
			$table -> integer('PaymentType')->nullable();
			$table -> integer('CashVoucherNo')->nullable();
			$table -> integer('CheckVoucherNo')->nullable();
			$table->timestamp('CheckDueDate')->nullable();
			$table -> integer('CheckNo')->nullable();
			$table -> integer('BankNo')->nullable()->unsigned();
			$table -> decimal('amount', 19, 4)->nullable();
			$table -> string('PreparedBy',250)->nullable();
			$table -> string('ApprovedBy',250)->nullable();
			$table -> boolean('IsCancelled')->default(0);
			$table -> string('CancelledBy',250)->nullable();
			$table -> timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('BillPayments');
	}

}
