<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToBills extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Bills', function(Blueprint $table)
		{
			$table-> foreign('PurchaseOrderNo')->references('id')->on('PurchaseOrders')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('SupplierNo')->references('id')->on('Suppliers')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('BranchNo')->references('id')->on('Branches')
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
		Schema::table('Bills', function(Blueprint $table)
		{
			$table->dropForeign('Bills_PurchaseOrderNo_foreign');
			$table->dropForeign('Bills_SupplierNo_foreign');
			$table->dropForeign('BranchNo');
		});
	}

}
