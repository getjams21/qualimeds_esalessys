<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToSupplierReturnDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('SupplierReturnDetails', function(Blueprint $table)
		{
			$table-> foreign('ProductNo')->references('id')->on('Products')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('SupplierReturnNo')->references('id')->on('SupplierReturns')
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
		Schema::table('SupplierReturnDetails', function(Blueprint $table)
		{
			$table->dropForeign('SupplierReturnDetails_ProductNo_foreign');
			$table->dropForeign('SupplierReturnDetails_SupplierReturnNo_foreign');
		});
	}

}
