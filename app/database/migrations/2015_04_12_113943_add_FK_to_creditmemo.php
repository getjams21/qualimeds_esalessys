<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFKToCreditmemo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('creditmemo', function(Blueprint $table)
		{
			$table-> foreign('customerno')->references('id')->on('customers')
			->onDelete('restrict')->onUpdate('cascade');
			$table-> foreign('branchno')->references('id')->on('branches')
			->onDelete('restrict')->onUpdate('cascade');
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
			$table->dropForeign('creditmemo_customerno_foreign');
			$table->dropForeign('creditmemo_branchno_foreign');
			$table->dropForeign('creditmemo_userno_foreign');
		});
	}

}
