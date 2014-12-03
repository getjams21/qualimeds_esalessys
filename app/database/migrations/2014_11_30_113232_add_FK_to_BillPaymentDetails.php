<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToBillPaymentDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('billpaymentdetails', function(Blueprint $table)
		{
			$table-> foreign('BillPaymentNo')->references('id')->on('BillPayments')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('BillNo')->references('id')->on('Bills')
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
		Schema::table('billpaymentdetails', function(Blueprint $table)
		{
			$table->dropForeign('billpaymentdetails_BillPaymentNo_foreign');
			$table->dropForeign('billpaymentdetails_BillNo_foreign');
		});
	}

}
