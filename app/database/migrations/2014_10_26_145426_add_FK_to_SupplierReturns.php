<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToSupplierReturns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('SupplierReturns', function(Blueprint $table)
		{
			$table-> foreign('BillNo')->references('id')->on('Bills')
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
		Schema::table('SupplierReturns', function(Blueprint $table)
		{
			$table->dropForeign('SupplierReturns_BillNo_foreign');
			$table->dropForeign('SupplierReturns_BranchNo_foreign');
		});
	}

}
