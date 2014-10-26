<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesCreditsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('SalesCredits', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> integer('BranchNo')->nullable()->unsigned();
			$table -> integer('SalesInvoiceNo')->nullable()->unsigned();
			$table->timestamp('SalesCreditDate')->nullable();
			$table -> decimal('Amount', 19, 4)->nullable();
			$table -> string('Remarks',500)->nullable();
			$table -> string('PreparedBy',250)->nullable();
			$table -> string('ApprovedBy',250)->nullable();
			$table -> boolean('IsCancelled')->default(0);
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
		Schema::drop('SalesCredits');
	}

}
