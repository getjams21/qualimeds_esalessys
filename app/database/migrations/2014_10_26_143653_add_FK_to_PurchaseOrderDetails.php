<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToPurchaseOrderDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('PurchaseOrderDetails', function(Blueprint $table)
		{
			$table-> foreign('ProductNo')->references('id')->on('Products')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('PurchaseOrderNo')->references('id')->on('PurchaseOrders')
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
		Schema::table('PurchaseOrderDetails', function(Blueprint $table)
		{
			$table->dropForeign('PurchaseOrderDetails_ProductNo_foreign');
			$table->dropForeign('PurchaseOrderDetails_PurchaseOrderNo_foreign');
		}); 
	}

}
