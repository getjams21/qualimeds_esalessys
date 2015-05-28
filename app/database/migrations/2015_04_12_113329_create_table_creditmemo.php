<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableCreditmemo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('creditmemo', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('customerno')->unsigned();
			$table->datetime('creditmemodate');
			$table->text('remarks');
			$table->decimal('amount',10,2);
			$table->integer('branchno')->unsigned();
			$table->integer('userno')->unsigned();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('creditmemo');
	}

}
