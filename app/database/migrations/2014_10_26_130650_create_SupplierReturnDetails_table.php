<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierReturnDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('SupplierReturnDetails', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> integer('SupplierReturnNo')->nullable()->unsigned();
			$table -> integer('ProductNo')->nullable()->unsigned();
			$table -> string('Unit',25)->nullable();
			$table -> string('LotNo',25)->nullable();
			$table->timestamp('ExpiryDate')->nullable();
			$table -> decimal('Qty', 18, 2)->nullable();
			$table -> decimal('FreebiesQty', 18, 2)->nullable();
			$table -> string('FreebiesUnit',25)->nullable();
			$table -> decimal('CostPerQty', 19, 4)->nullable();
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
		Schema::drop('SupplierReturnDetails');
	}

}
