<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToCustomerReturnDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('CustomerReturnDetails', function(Blueprint $table)
		{
			$table-> foreign('CustomerReturnNo')->references('id')->on('CustomerReturns')
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
		Schema::table('CustomerReturnDetails', function(Blueprint $table)
		{
			$table->dropForeign('CustomerReturnDetails_CustomerReturnNo_foreign');
			$table->dropForeign('CustomerReturnDetails_ProductNo_foreign');
		});
	}

}
