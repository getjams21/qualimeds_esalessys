<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Suppliers', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> string('SupplierName',250)->nullable();
			$table -> string('Address',500)->nullable();
			$table -> string('Telephone1',20)->nullable();
			$table -> string('Telephone2',20)->nullable();
			$table -> string('ContactPerson',150)->nullable();
			$table -> boolean('IsActive')->default(1);
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
		Schema::drop('Suppliers');
	}

}
