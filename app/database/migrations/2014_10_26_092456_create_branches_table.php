<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Branches', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> string('BranchName',250)->nullable();
			$table -> string('BAddress',500)->nullable();
			$table -> string('Telephone',20)->nullable();
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
		Schema::drop('Branches');
	}

}
