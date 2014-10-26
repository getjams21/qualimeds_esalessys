<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToInventoryDamageDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('InventoryDamageDetails', function(Blueprint $table)
		{
			$table-> foreign('InvDamagesNo')->references('id')->on('InventoryDamages')
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
		Schema::table('InventoryDamageDetails', function(Blueprint $table)
		{
			$table->dropForeign('InventoryDamageDetails_InvDamagesNo_foreign');
			$table->dropForeign('InventoryDamageDetails_ProductNo_foreign');
		});
	}

}
