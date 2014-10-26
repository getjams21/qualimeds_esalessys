<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('PaymentDetails', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> integer('PaymentNo')->nullable()->unsigned();
			$table -> integer('SalesInvoiceNo')->nullable()->unsigned();
			$table -> integer('PaymentType')->nullable();
			$table -> integer('CheckNo')->nullable();
			$table->timestamp('CheckDueDate')->nullable();
			$table -> decimal('amount', 19, 4)->nullable();
			$table -> integer('BankNo')->nullable()->unsigned();
			$table -> boolean('IsCheckEncash')->default(0);
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
		Schema::drop('PaymentDetails');
	}

}
