<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToPaymentDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('PaymentDetails', function(Blueprint $table)
		{
			$table-> foreign('BankNo')->references('id')->on('Banks')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('PaymentNo')->references('id')->on('Payments')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('SalesInvoiceNo')->references('id')->on('SalesInvoices')
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
		Schema::table('PaymentDetails', function(Blueprint $table)
		{
			$table->dropForeign('PaymentDetails_BankNo_foreign');
			$table->dropForeign('PaymentDetails_PaymentNo_foreign');
			$table->dropForeign('PaymentDetails_SalesInvoiceNo_foreign');
		});
	}

}
