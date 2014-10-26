<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToPurchaseOrders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('PurchaseOrders', function(Blueprint $table)
		{
			$table-> foreign('BranchNo')->references('id')->on('Branches')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('SupplierNo')->references('id')->on('Suppliers')
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
		Schema::table('PurchaseOrders', function(Blueprint $table)
		{
			$table->dropForeign('PurchaseOrders_BranchNo_foreign');
			$table->dropForeign('PurchaseOrders_SupplierNo_foreign');
		});
	}

}
