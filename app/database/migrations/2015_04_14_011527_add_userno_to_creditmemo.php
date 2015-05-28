<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsernoToCreditmemo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('creditmemo', function(Blueprint $table)
		{
			$table -> integer('userno')->nullable()->unsigned();
			$table-> foreign('userno')->references('id')->on('users')
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
		Schema::table('creditmemo', function(Blueprint $table)
		{
			$table->dropForeign('creditmemo_userno_foreign');
		});
	}

}
