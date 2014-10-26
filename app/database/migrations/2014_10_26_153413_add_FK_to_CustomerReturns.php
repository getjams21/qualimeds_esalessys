<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToCustomerReturns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('CustomerReturns', function(Blueprint $table)
		{
			$table-> foreign('SalesinvoiceNo')->references('id')->on('SalesInvoices')
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
		Schema::table('CustomerReturns', function(Blueprint $table)
		{
			$table->dropForeign('CustomerReturns_SalesinvoiceNo_foreign');
		});
	}

}
