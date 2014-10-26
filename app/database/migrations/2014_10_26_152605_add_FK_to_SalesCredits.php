<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToSalesCredits extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('SalesCredits', function(Blueprint $table)
		{
			$table-> foreign('BranchNo')->references('id')->on('Branches')
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
		Schema::table('SalesCredits', function(Blueprint $table)
		{
			$table->dropForeign('SalesCredits_ProductNo_foreign');
			$table->dropForeign('SalesCredits_SalesInvoiceNo_foreign');
		});
	}

}
