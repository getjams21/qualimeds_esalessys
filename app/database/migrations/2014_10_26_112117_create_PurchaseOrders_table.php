<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('PurchaseOrders', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> integer('BranchNo')->nullable()->unsigned();
			$table -> integer('SupplierNo')->nullable()->unsigned();
			$table->timestamp('PODate')->nullable();
			$table -> integer('Terms')->nullable();
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
		Schema::drop('PurchaseOrders');
	}

}
