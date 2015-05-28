<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Users', function(Blueprint $table)
		{
			$table-> foreign('BranchNo')->references('id')->on('Branches')
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
		Schema::table('Users', function(Blueprint $table)
		{
			$table->dropForeign('Users_BranchNo_foreign');
		});
	}

}
