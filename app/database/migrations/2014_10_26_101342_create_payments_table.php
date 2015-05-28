<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Payments', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> integer('BranchNo')->nullable()->unsigned();
			$table -> integer('ORnumber')->nullable();
			$table->timestamp('PaymentDate')->nullable();
			$table -> integer('UserNo')->nullable();
			$table -> string('EncodedBy',250)->nullable();
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
		Schema::drop('Payments');
	}

}
