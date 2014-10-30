<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Bills', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> integer('PurchaseOrderNo')->nullable()->unsigned();
			$table -> integer('SupplierNo')->nullable()->unsigned();
			$table -> integer('BranchNo')->nullable()->unsigned();
			$table->timestamp('BillDate')->nullable();
			$table -> integer('SalesInvoiceNo')->nullable();
			$table->timestamp('SalesInvoiceDate')->nullable();
			$table -> integer('Terms')->nullable();
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
		Schema::drop('Bills');
	}

}
