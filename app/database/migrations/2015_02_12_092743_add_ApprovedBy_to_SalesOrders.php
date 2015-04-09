<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApprovedByToSalesOrders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('salesorders', function(Blueprint $table)
		{
			$table -> string('PreparedBy',250)->nullable();
			$table -> string('ApprovedBy',250)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('salesorders', function(Blueprint $table)
		{
			//
		});
	}

}