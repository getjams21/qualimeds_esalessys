<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToSalesInvoiceDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('SalesInvoiceDetails', function(Blueprint $table)
		{
			$table-> foreign('ProductNo')->references('id')->on('Products')
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
		Schema::table('SalesInvoiceDetails', function(Blueprint $table)
		{
			$table->dropForeign('SalesInvoiceDetails_ProductNo_foreign');
			$table->dropForeign('SalesInvoiceDetails_SalesInvoiceNo_foreign');
		});
	}

}
