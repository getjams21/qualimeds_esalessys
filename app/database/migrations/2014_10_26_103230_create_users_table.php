<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Users', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> string('username',25)->unique();
			$table -> string('password',100);
			$table -> string('Lastname',150)->nullable();
			$table -> string('Firstname',150)->nullable();
			$table -> string('MI',1)->nullable();
			$table -> integer('UserType')->nullable();
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
		Schema::drop('Users');
	}

}
