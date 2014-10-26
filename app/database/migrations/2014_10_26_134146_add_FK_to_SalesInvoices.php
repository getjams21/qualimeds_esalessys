<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToSalesInvoices extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('SalesInvoices', function(Blueprint $table)
		{
			$table-> foreign('BranchNo')->references('id')->on('Branches')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('CustomerNo')->references('id')->on('Customers')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('SalesOrderNo')->references('id')->on('SalesOrders')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('UserNo')->references('id')->on('Users')
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
		Schema::table('SalesInvoices', function(Blueprint $table)
		{
			$table->dropForeign('SalesInvoices_BranchNo_foreign');
			$table->dropForeign('SalesInvoices_CustomerNo_foreign');
			$table->dropForeign('SalesInvoices_SalesOrderNo_foreign');
			$table->dropForeign('SalesInvoices_UserNo_foreign');
		});
	}

}
