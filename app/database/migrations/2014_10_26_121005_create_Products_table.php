<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Products', function(Blueprint $table)
		{
			$table -> increments('id');
			$table -> integer('ProductCatNo')->nullable()->unsigned();
			$table -> string('ProductName')->nullable();
			$table -> string('BrandName')->nullable();
			$table -> string('WholeSaleUnit',25)->nullable();
			$table -> string('RetailUnit',25)->nullable();
			$table -> decimal('RetailQtyPerWholeSaleUnit', 18, 2)->nullable();
			$table -> integer('Markup1')->nullable();
			$table -> integer('Markup2')->nullable();
			$table -> integer('Markup3')->nullable();
			$table -> integer('ActiveMarkup')->nullable();
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
		Schema::drop('Products');
	}

}
