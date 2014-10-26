<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOrderDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('SalesOrderDetails', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> integer('SalesOrderNo')->nullable()->unsigned();
			$table -> integer('ProductNo')->nullable()->unsigned();
			$table -> string('Barcode',25)->nullable();
			$table -> string('Unit',25)->nullable();
			$table -> string('LotNo',25)->nullable();
			$table->timestamp('ExpiryDate')->nullable();
			$table -> decimal('Qty', 18, 2)->nullable();
			$table -> decimal('UnitPrice', 19, 4)->nullable();
			$table -> timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('SalesOrderDetails');
	}

}
