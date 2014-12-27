<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentinvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('paymentinvoices', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> integer('paymentNo')->nullable()->unsigned();
			$table -> integer('invoiceNo')->nullable()->unsigned();
			$table -> decimal('amount', 19, 4)->nullable();
			$table -> timestamps();
			$table-> foreign('paymentNo')->references('id')->on('payments')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('invoiceNo')->references('id')->on('salesinvoices')
			->onDelete('restrict')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('paymentinvoices', function(Blueprint $table)
		{
			Schema::drop('paymentinvoices');
		});
	}

}
