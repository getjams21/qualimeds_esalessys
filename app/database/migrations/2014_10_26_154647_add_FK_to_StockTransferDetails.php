<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToStockTransferDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('StockTransferDetails', function(Blueprint $table)
		{
			$table-> foreign('ProductNo')->references('id')->on('Products')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('StockTransferNo')->references('id')->on('StockTransfers')
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
		Schema::table('StockTransferDetails', function(Blueprint $table)
		{
			$table->dropForeign('StockTransferDetails_ProductNo_foreign');
			$table->dropForeign('StockTransferDetails_StockTransferNo_foreign');
		});
	}

}
