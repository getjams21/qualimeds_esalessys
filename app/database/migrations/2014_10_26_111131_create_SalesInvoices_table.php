<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('SalesInvoices', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> integer('BranchNo')->nullable()->unsigned();
			$table -> integer('SalesInvoiceRefDocNo')->nullable();
			$table -> integer('SalesOrderNo')->nullable()->unsigned();
			$table->timestamp('InvoiceDate')->nullable();
			$table -> integer('CustomerNo')->nullable()->unsigned();
			$table -> integer('UserNo')->nullable()->unsigned();
			$table -> integer('Terms')->nullable();
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
		Schema::drop('SalesInvoices');
	}

}
