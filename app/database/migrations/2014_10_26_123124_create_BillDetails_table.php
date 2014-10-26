<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('BillDetails', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> integer('BillNo')->nullable()->unsigned();
			$table -> integer('ProductNo')->nullable()->unsigned();
			$table -> string('Barcode',25)->nullable();
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
		Schema::drop('BillDetails');
	}

}
