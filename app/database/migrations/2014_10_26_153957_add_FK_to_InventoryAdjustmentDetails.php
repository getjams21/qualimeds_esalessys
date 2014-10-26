<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToInventoryAdjustmentDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('InventoryAdjustmentDetails', function(Blueprint $table)
		{
			$table-> foreign('InvAdjustmentNo')->references('id')->on('InventoryAdjustments')
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
		Schema::table('InventoryAdjustmentDetails', function(Blueprint $table)
		{
			$table->dropForeign('InventoryAdjustmentDetails_InvAdjustmentNo_foreign');
			$table->dropForeign('InventoryAdjustmentDetails_ProductNo_foreign');
		});
	}

}
