<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFKToProducts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Products', function(Blueprint $table)
		{
			$table-> foreign('ProductCatNo')->references('id')->on('ProductCategories')
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
		Schema::table('Products', function(Blueprint $table)
		{
			$table->dropForeign('Products_ProductCatNo_foreign');
		});
	}

}
