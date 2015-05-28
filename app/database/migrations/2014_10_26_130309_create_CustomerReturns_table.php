<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerReturnsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('CustomerReturns', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> integer('SalesinvoiceNo')->nullable()->unsigned();
			$table -> integer('BranchNo')->nullable()->unsigned();
			$table->timestamp('CustomerReturnDate')->nullable(); 
			$table -> string('Remarks',500)->nullable();
			$table -> string('PreparedBy',250)->nullable();
			$table -> string('ApprovedBy',250)->nullable();
			$table -> string('IsCancelled',1)->default('N');
			$table -> string('CancelledBy',250)->nullable();
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
		Schema::drop('CustomerReturns');
	}

}
