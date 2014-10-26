<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToBillDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('BillDetails', function(Blueprint $table)
		{
			$table-> foreign('BillNo')->references('id')->on('Bills')
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
		Schema::table('BillDetails', function(Blueprint $table)
		{
			$table->dropForeign('BillDetails_BillNo_foreign');
			$table->dropForeign('BillDetails_ProductNo_foreign');
		});
	}

}
