<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToInventoryAdjustments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('InventoryAdjustments', function(Blueprint $table)
		{
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
		Schema::table('InventoryAdjustments', function(Blueprint $table)
		{
			$table->dropForeign('InventoryAdjustments_BranchNo_foreign');
		});
	}

}
