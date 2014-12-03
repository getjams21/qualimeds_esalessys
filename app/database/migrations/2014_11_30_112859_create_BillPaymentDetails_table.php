<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillPaymentDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('billpaymentdetails', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> integer('BillPaymentNo')->nullable()->unsigned();
			$table -> integer('BillNo')->nullable()->unsigned();
			$table -> decimal('Amount', 19, 4)->nullable();
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
		Schema::table('billpaymentdetails', function(Blueprint $table)
		{
			Schema::drop('SupplierReturnDetails');
		});
	}

}
