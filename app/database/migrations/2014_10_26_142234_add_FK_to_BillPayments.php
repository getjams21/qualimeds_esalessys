<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToBillPayments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('BillPayments', function(Blueprint $table)
		{
			$table-> foreign('BankNo')->references('id')->on('Banks')
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
		Schema::table('BillPayments', function(Blueprint $table)
		{
			$table->dropForeign('BillPayments_BankNo_foreign');
			$table->dropForeign('BillPayments_BillNo_foreign');
		});
	}

}
