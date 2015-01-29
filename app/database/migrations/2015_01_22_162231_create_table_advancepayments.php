<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdvancepayments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('advancepayments', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> integer('paymentNo')->nullable()->unsigned();
			$table -> integer('chargedPaymentNo')->nullable()->unsigned();
			$table -> integer('customerNo')->nullable()->unsigned();
			$table -> decimal('amount', 19, 4)->nullable();
			$table -> boolean('isCharged')->default(0);
			$table -> timestamps();
			$table-> foreign('paymentNo')->references('id')->on('payments')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('chargedPaymentNo')->references('id')->on('payments')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('customerNo')->references('id')->on('customers')
			->onDelete('restrict')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('advancepayments', function(Blueprint $table)
		{
			Schema::drop('advancepayments');
		});
	}

}
