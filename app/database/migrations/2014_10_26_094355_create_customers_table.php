<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Customers', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> string('CustomerName',250)->nullable();
			$table -> string('Address',500)->nullable();
			$table -> string('Telephone1',20)->nullable();
			$table -> string('Telephone2',20)->nullable();
			$table -> string('ContactPerson',150)->nullable();
			$table -> decimal('CreditLimit', 19, 4)->nullable();
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
		Schema::drop('Customers');
	}

}
