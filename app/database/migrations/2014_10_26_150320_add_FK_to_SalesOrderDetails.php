<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToSalesOrderDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('SalesOrderDetails', function(Blueprint $table)
		{
			$table-> foreign('SalesOrderNo')->references('id')->on('SalesOrders')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('ProductNo')->references('id')->on('Products')
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
		Schema::table('SalesOrderDetails', function(Blueprint $table)
		{
			$table->dropForeign('SalesOrderDetails_SalesOrderNo_foreign');
			$table->dropForeign('SalesOrderDetails_ProductNo_foreign');
		});
	}

}
